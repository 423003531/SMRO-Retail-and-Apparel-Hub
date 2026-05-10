<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    // Automatically link this controller to your ProductModel
    protected $modelName = 'App\Models\ProductModel';
    // Force the API to always return JSON
    protected $format    = 'json';

    /**
     * GET /api/products
     * Returns a list of all products in JSON format
     */
    public function index()
    {
        $products = $this->model->findAll();
        
        if (empty($products)) {
            return $this->failNotFound('No products found in the inventory.');
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }
}