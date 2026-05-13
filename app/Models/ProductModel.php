<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Enabling Soft Deletes because of your deleted_at column!
    protected $useSoftDeletes   = true;
    
    // Merged your existing columns + the new retail columns + the new 'price' column
    protected $allowedFields    = [
        'sku', 'name', 'description', 'price', 'base_image', 'category', 
        'selling_price', 'cost_price', 'sizes', 'colors', 
        'supplier', 'total_stock', 'status'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}