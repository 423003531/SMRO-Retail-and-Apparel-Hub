<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\StockLogModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        $search  = $this->request->getGet('search') ?? '';
        $perPage = 10;

        if ($search) {
            $products = $productModel
                ->like('name', $search)
                ->orLike('sku', $search)
                ->orLike('category', $search)
                ->paginate($perPage, 'default');
        } else {
            $products = $productModel->paginate($perPage, 'default');
        }

        $data = array_merge($this->data, [
            'title'    => 'Products Management',
            'products' => $products,
            'pager'    => $productModel->pager,
            'search'   => $search
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

        $imageName = null;
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/products', $imageName);
        }

        $variants    = $this->request->getPost('variants');
        $totalStock  = 0;
        $sizesArray  = [];
        $colorsArray = [];

        if ($variants) {
            foreach ($variants as $v) {
                $totalStock += (int)$v['stock_quantity'];
                if (!empty($v['size']))  $sizesArray[]  = $v['size'];
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
            'total_stock'   => $totalStock,
            'status'        => $this->request->getPost('status') ?? 'Active',
            'base_image'    => $imageName,
        ];

        $productId = $productModel->insert($saveData, true);

        if ($productId && $variants) {
            $variantModel  = new ProductVariantModel();
            $stockLogModel = new StockLogModel();

            foreach ($variants as $variant) {
                $variant['product_id'] = $productId;
                $variantId = $variantModel->insert($variant, true);

                if ((int)$variant['stock_quantity'] > 0) {
                    $stockLogModel->insert([
                        'product_id'    => $productId,
                        'variant_id'    => $variantId,
                        'movement_type' => 'in',
                        'quantity'      => (int)$variant['stock_quantity'],
                        'remarks'       => 'Initial stock from product creation'
                    ]);
                }
            }
        }

        return redirect()->to('products')->with('success', 'Product added successfully!');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if ($product && !empty($product['base_image'])) {
            $imagePath = FCPATH . 'uploads/products/' . $product['base_image'];
            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $productModel->delete($id);

        return redirect()->to('products')->with('success', 'Product and its image deleted successfully!');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $product      = $productModel->find($id);

        $variantModel = new ProductVariantModel();
        $variants     = $variantModel->where('product_id', $id)->findAll();

        $data = array_merge($this->data, [
            'title'    => 'Edit Product',
            'product'  => $product,
            'variants' => $variants
        ]);

        return view('pages/products/edit', $data);
    }

    public function update($id)
    {
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
        $oldProduct   = $productModel->find($id);

        $variants    = $this->request->getPost('variants');
        $totalStock  = 0;
        $sizesArray  = [];
        $colorsArray = [];

        if ($variants) {
            foreach ($variants as $v) {
                $totalStock += (int)$v['stock_quantity'];
                if (!empty($v['size']))  $sizesArray[]  = $v['size'];
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
            'total_stock'   => $totalStock,
            'status'        => $this->request->getPost('status') ?? 'Active',
        ];

        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/products', $imageName);
            $updateData['base_image'] = $imageName;

            if (!empty($oldProduct['base_image'])) {
                $oldImagePath = FCPATH . 'uploads/products/' . $oldProduct['base_image'];
                if (is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $productModel->update($id, $updateData);

        $variantModel  = new ProductVariantModel();
        $stockLogModel = new StockLogModel();

        $oldVariants    = $variantModel->where('product_id', $id)->findAll();
        $oldVariantsMap = [];
        foreach ($oldVariants as $ov) {
            $oldVariantsMap[$ov['sku']] = $ov;
        }

        $processedSkus = [];

        if ($variants) {
            foreach ($variants as $variant) {
                $variant['product_id'] = $id;
                $sku = $variant['sku'];
                $processedSkus[] = $sku;

                if (isset($oldVariantsMap[$sku])) {
                    $oldVariant = $oldVariantsMap[$sku];
                    $variantId  = $oldVariant['id'];
                    $variantModel->update($variantId, $variant);

                    $diff = (int)$variant['stock_quantity'] - (int)$oldVariant['stock_quantity'];
                    if ($diff !== 0) {
                        $stockLogModel->insert([
                            'product_id'    => $id,
                            'variant_id'    => $variantId,
                            'movement_type' => $diff > 0 ? 'in' : 'out',
                            'quantity'      => abs($diff),
                            'remarks'       => 'Stock adjusted via product edit'
                        ]);
                    }
                } else {
                    $variantId = $variantModel->insert($variant, true);
                    if ((int)$variant['stock_quantity'] > 0) {
                        $stockLogModel->insert([
                            'product_id'    => $id,
                            'variant_id'    => $variantId,
                            'movement_type' => 'in',
                            'quantity'      => (int)$variant['stock_quantity'],
                            'remarks'       => 'New variant added via product edit'
                        ]);
                    }
                }
            }
        }

        foreach ($oldVariantsMap as $sku => $ov) {
            if (!in_array($sku, $processedSkus)) {
                $variantModel->delete($ov['id']);

                if ((int)$ov['stock_quantity'] > 0) {
                    $stockLogModel->insert([
                        'product_id'    => $id,
                        'variant_id'    => $ov['id'],
                        'movement_type' => 'out',
                        'quantity'      => (int)$ov['stock_quantity'],
                        'remarks'       => 'Variant deleted from catalog'
                    ]);
                }
            }
        }

        return redirect()->to('products')->with('success', 'Product updated successfully!');
    }
}