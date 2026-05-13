<?php

namespace App\Controllers;

use App\Models\ProductVariantModel;
use App\Models\StockLogModel;
use App\Models\OrderModel;     // NEW: Added this to load the Order model
use App\Models\OrderItemModel; // NEW: Added this to load the Order Item model

class Pos extends BaseController
{
    public function index()
    {
        $variantModel = new ProductVariantModel();

        // Fetch items joined with their product names and selling prices
        $availableItems = $variantModel->select('product_variants.*, products.name as product_name, products.selling_price')
                                       ->join('products', 'products.id = product_variants.product_id', 'inner')
                                       ->where('stock_quantity >', 0)
                                       ->findAll();

        $data = array_merge($this->data, [
            'title'          => 'Point of Sale (POS)',
            'availableItems' => $availableItems
        ]);

        return view('pages/pos/index', $data);
    }

    public function checkout()
    {
        // 1. Grab the JSON string sent from the frontend cart
        $cartData = $this->request->getPost('cart_data');

        if (empty($cartData)) {
            return redirect()->back()->with('error', 'The cart is empty. Cannot complete sale.');
        }

        // 2. Decode the JSON string back into a PHP array
        $cartItems = json_decode($cartData, true);
        
        // Load all the necessary models
        $variantModel   = new ProductVariantModel();
        $stockLogModel  = new StockLogModel();
        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();
        
        // 3. Calculate the Total Amount of the order
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += ($item['price'] * $item['quantity']);
        }

        // 4. Start a Database Transaction for safety
        $db = \Config\Database::connect();
        $db->transStart();

        // 5. Create the Main Order (The Receipt)
        $orderNumber = 'ORD-' . strtoupper(uniqid()); // Generates a unique ID like ORD-64A7F...
        
        // Insert and grab the new order's ID
        $orderId = $orderModel->insert([
            'order_number' => $orderNumber,
            'total_amount' => $totalAmount
        ]);

        // 6. Loop through each item in the cart and process it
        foreach ($cartItems as $item) {
            $variantId = $item['id'];
            $quantitySold = $item['quantity'];
            $price = $item['price'];

            // Find the item in the database
            $variant = $variantModel->find($variantId);

            if ($variant) {
                // --- A. SAVE THE ORDER LINE ITEM ---
                $orderItemModel->insert([
                    'order_id'   => $orderId,
                    'product_id' => $variant['product_id'],
                    'variant_id' => $variantId,
                    'quantity'   => $quantitySold,
                    'price'      => $price
                ]);

                // --- B. DEDUCT STOCK ---
                // Calculate new stock (and prevent it from going below 0)
                $newStock = $variant['stock_quantity'] - $quantitySold;
                $newStock = ($newStock < 0) ? 0 : $newStock;

                // Update the variant's stock in the database
                $variantModel->update($variantId, ['stock_quantity' => $newStock]);

                // --- C. RECORD IN LEDGER ---
                // Insert the movement into the stock_logs table
                $stockLogModel->insert([
                    'product_id'    => $variant['product_id'],
                    'variant_id'    => $variantId,
                    'movement_type' => 'OUT',
                    'quantity'      => $quantitySold,
                    'remarks'       => 'POS Sale (' . $orderNumber . ')' // Bonus: Order Number included!
                ]);
            }
        }

        // 7. Complete the Transaction
        $db->transComplete();

        // 8. Check if it succeeded and redirect back
        if ($db->transStatus() === false) {
            return redirect()->to('/pos')->with('error', 'Something went wrong while processing the sale.');
        }

        // Redirect back to POS with the success message showing the Order ID
        return redirect()->to('sales/' . $orderId);    }
}