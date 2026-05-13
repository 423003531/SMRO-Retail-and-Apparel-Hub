<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // The columns we are allowed to insert data into
    protected $allowedFields    = [
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price'
    ];

    // We usually don't need timestamps for individual line items if the main order has one
    protected $useTimestamps = false; 
}