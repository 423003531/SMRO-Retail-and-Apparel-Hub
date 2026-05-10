<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductVariantModel; // Added Variant Model

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $allProducts = $productModel->findAll();

        $data = array_merge($this->data, [
            'title'    => 'Products Management',
            'products' => $allProducts
        ]);

        return view('pages/products/index', $data);
    }

    public function create()
    {
        $data = array_merge($this->data, [
            'title' => 'Add New Product'
        ]);

        return view('pages/products/create', $data);
    }

    public function store()
    {
        // Removed 'total_stock' from required rules
        $rules = [
            'sku'           => 'required|min_length[2]|is_unique[products.sku]',
            'name'          => 'required|min_length[3]',
            'category'      => 'required',
            'selling_price' => 'required|numeric',
            'image'         => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- IMAGE UPLOAD LOGIC ---
        $imageName = null; 
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/products', $imageName);
        }

        // --- CALCULATE TOTALS FROM VARIANTS ---
        $variants = $this->request->getPost('variants');
        $totalStock = 0;
        $sizesArray = [];
        $colorsArray = [];

        if ($variants) {
            foreach ($variants as $v) {
                $totalStock += (int)$v['stock_quantity'];
                if (!empty($v['size'])) $sizesArray[] = $v['size'];
                if (!empty($v['color'])) $colorsArray[] = $v['color'];
            }
        }

        $productModel = new ProductModel();
        
        $saveData = [
            'sku'           => $this->request->getPost('sku'),
            'name'          => $this->request->getPost('name'),
            'category'      => $this->request->getPost('category'),
            'selling_price' => $this->request->getPost('selling_price'),
            'cost_price'    => $this->request->getPost('cost_price'),
            'sizes'         => implode(', ', array_unique($sizesArray)),
            'colors'        => implode(', ', array_unique($colorsArray)),
            'total_stock'   => $totalStock, // Auto-calculated!
            'status'        => $this->request->getPost('status') ?? 'Active',
            'base_image'    => $imageName,
        ];

        // Insert returns the new product's ID
        $productId = $productModel->insert($saveData, true);

        // --- SAVE VARIANTS ---
        if ($productId && $variants) {
            $variantModel = new ProductVariantModel();
            foreach ($variants as $variant) {
                $variant['product_id'] = $productId; // Link it to the main product
                $variantModel->insert($variant);
            }
        }

        return redirect()->to('products')->with('success', 'Product added successfully!');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        
        // 1. Find the product first to get the image filename
        $product = $productModel->find($id);
        
        // 2. Check if the product exists and actually has an image
        if ($product && !empty($product['base_image'])) {
            // FCPATH points to your public folder path
            $imagePath = FCPATH . 'uploads/products/' . $product['base_image'];
            
            // 3. If the file exists on the server, delete it
            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        // 4. Delete the product from the database
        // NOTE: Variants will delete automatically because of ON DELETE CASCADE in the database
        $productModel->delete($id);

        return redirect()->to('products')->with('success', 'Product and its image deleted successfully!');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        // Fetch attached variants
        $variantModel = new ProductVariantModel();
        $variants = $variantModel->where('product_id', $id)->findAll();

        $data = array_merge($this->data, [
            'title'    => 'Edit Product',
            'product'  => $product,
            'variants' => $variants // Pass variants to the view
        ]);

        return view('pages/products/edit', $data);
    }

    public function update($id)
    {
        // Removed 'total_stock' from required rules
        $rules = [
            'sku'           => "required|min_length[2]|is_unique[products.sku,id,{$id}]", 
            'name'          => 'required|min_length[3]',
            'category'      => 'required',
            'selling_price' => 'required|numeric',
            'image'         => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productModel = new ProductModel();
        $oldProduct = $productModel->find($id);
        
        // --- CALCULATE TOTALS FROM VARIANTS ---
        $variants = $this->request->getPost('variants');
        $totalStock = 0;
        $sizesArray = [];
        $colorsArray = [];

        if ($variants) {
            foreach ($variants as $v) {
                $totalStock += (int)$v['stock_quantity'];
                if (!empty($v['size'])) $sizesArray[] = $v['size'];
                if (!empty($v['color'])) $colorsArray[] = $v['color'];
            }
        }

        $updateData = [
            'sku'           => $this->request->getPost('sku'),
            'name'          => $this->request->getPost('name'),
            'category'      => $this->request->getPost('category'),
            'selling_price' => $this->request->getPost('selling_price'),
            'cost_price'    => $this->request->getPost('cost_price'),
            'sizes'         => implode(', ', array_unique($sizesArray)),
            'colors'        => implode(', ', array_unique($colorsArray)),
            'total_stock'   => $totalStock, // Auto-calculated!
            'status'        => $this->request->getPost('status') ?? 'Active',
        ];

        // --- IMAGE UPLOAD LOGIC FOR UPDATE ---
        $file = $this->request->getFile('image');
        
        // If a new valid file is uploaded
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/products', $imageName);
            
            $updateData['base_image'] = $imageName;

            // CLEANUP: Delete the old image file from the server
            if (!empty($oldProduct['base_image'])) {
                $oldImagePath = FCPATH . 'uploads/products/' . $oldProduct['base_image'];
                if (is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $productModel->update($id, $updateData);

        // --- SYNC VARIANTS ---
        $variantModel = new ProductVariantModel();
        
        // 1. Delete all old variants for this product
        $variantModel->where('product_id', $id)->delete();
        
        // 2. Insert the newly submitted ones
        if ($variants) {
            foreach ($variants as $variant) {
                $variant['product_id'] = $id; // Keep them linked to this product
                $variantModel->insert($variant);
            }
        }

        return redirect()->to('products')->with('success', 'Product updated successfully!');
    }
}