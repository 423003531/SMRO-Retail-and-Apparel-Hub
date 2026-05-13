<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // The fields we are allowed to save to
    protected $allowedFields    = ['order_id', 'product_id', 'variant_id', 'quantity', 'price'];

    // Automatically handle created_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // We didn't add an updated_at to the items table, so we leave this blank
}