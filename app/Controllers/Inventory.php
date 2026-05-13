<?php

namespace App\Controllers;

use App\Models\StockLogModel;
use App\Models\ProductVariantModel;
use App\Models\ProductModel;

class Inventory extends BaseController
{
    public function index()
    {
        $logModel = new StockLogModel();

        $search  = $this->request->getGet('search') ?? '';
        $perPage = 15;

        $builder = $logModel->select('stock_logs.*, products.name as product_name, product_variants.sku as variant_sku, product_variants.size, product_variants.color')
                            ->join('products', 'products.id = stock_logs.product_id', 'left')
                            ->join('product_variants', 'product_variants.id = stock_logs.variant_id', 'left')
                            ->orderBy('stock_logs.created_at', 'DESC');

        if ($search) {
            $builder->groupStart()
                    ->like('products.name', $search)
                    ->orLike('product_variants.sku', $search)
                    ->orLike('stock_logs.remarks', $search)
                    ->groupEnd();
        }

        $logs = $builder->paginate($perPage, 'default');

        $variantModel   = new ProductVariantModel();
        $activeVariants = $variantModel->select('product_variants.*, products.name as product_name')
                                       ->join('products', 'products.id = product_variants.product_id', 'inner')
                                       ->orderBy('products.name', 'ASC')
                                       ->findAll();

        $data = array_merge($this->data, [
            'title'    => 'Stock Ledger',
            'logs'     => $logs,
            'variants' => $activeVariants,
            'pager'    => $logModel->pager,
            'search'   => $search
        ]);

        return view('pages/inventory/index', $data);
    }

    public function adjust()
    {
        $variantId    = $this->request->getPost('variant_id');
        $movementType = $this->request->getPost('movement_type');
        $quantity     = (int) $this->request->getPost('quantity');
        $remarks      = $this->request->getPost('remarks');

        $variantModel  = new ProductVariantModel();
        $productModel  = new ProductModel();
        $stockLogModel = new StockLogModel();

        $variant = $variantModel->find($variantId);
        if (!$variant) {
            return redirect()->back()->with('error', 'Variant not found.');
        }

        $productId = $variant['product_id'];

        $newVariantStock = $movementType === 'in'
            ? $variant['stock_quantity'] + $quantity
            : $variant['stock_quantity'] - $quantity;

        if ($newVariantStock < 0) {
            return redirect()->back()->with('error', 'Error: Stock cannot drop below zero.');
        }

        $variantModel->update($variantId, ['stock_quantity' => $newVariantStock]);

        $stockLogModel->insert([
            'product_id'    => $productId,
            'variant_id'    => $variantId,
            'movement_type' => $movementType,
            'quantity'      => $quantity,
            'remarks'       => $remarks ?: 'Manual stock adjustment'
        ]);

        $allVariants = $variantModel->where('product_id', $productId)->findAll();
        $totalStock  = 0;
        foreach ($allVariants as $v) {
            $totalStock += (int)$v['stock_quantity'];
        }
        $productModel->update($productId, ['total_stock' => $totalStock]);

        return redirect()->to('inventory')->with('success', 'Stock adjusted successfully!');
    }

    public function export()
    {
        $logModel = new StockLogModel();

        $search = $this->request->getGet('search') ?? '';

        $builder = $logModel->select('stock_logs.*, products.name as product_name, product_variants.sku as variant_sku, product_variants.size, product_variants.color')
                            ->join('products', 'products.id = stock_logs.product_id', 'left')
                            ->join('product_variants', 'product_variants.id = stock_logs.variant_id', 'left')
                            ->orderBy('stock_logs.created_at', 'DESC');

        if ($search) {
            $builder->groupStart()
                    ->like('products.name', $search)
                    ->orLike('product_variants.sku', $search)
                    ->orLike('stock_logs.remarks', $search)
                    ->groupEnd();
        }

        $logs = $builder->findAll();

        $filename = 'inventory_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['Date & Time', 'Product', 'SKU', 'Size', 'Color', 'Movement', 'Quantity', 'Remarks']);

        foreach ($logs as $log) {
            fputcsv($output, [
                $log['created_at'],
                $log['product_name'],
                $log['variant_sku'],
                $log['size'],
                $log['color'],
                strtoupper($log['movement_type']),
                $log['quantity'],
                $log['remarks']
            ]);
        }

        fclose($output);
        exit;
    }
}