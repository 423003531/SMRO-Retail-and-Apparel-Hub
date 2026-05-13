<?php

namespace App\Models;

use CodeIgniter\Model;

class StockLogModel extends Model
{
    protected $table            = 'stock_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // The columns we are allowed to insert data into
    protected $allowedFields    = [
        'product_id',
        'variant_id',
        'movement_type',
        'quantity',
        'remarks',
        'created_at'
    ];

    // Automatically handle the 'created_at' timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Left blank because we don't update logs, we only create them
}