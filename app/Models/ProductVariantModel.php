<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table            = 'product_variants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // These are the exact columns we just created in the migration
    protected $allowedFields    = [
        'product_id',
        'sku',
        'size',
        'color',
        'price',
        'stock_quantity'
    ];

    // Enable automatic timestamps so CodeIgniter fills in created_at and updated_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}