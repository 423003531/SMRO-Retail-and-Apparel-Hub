<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\StockLogModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel   = new ProductModel();
        $variantModel   = new ProductVariantModel();
        $logModel       = new StockLogModel();
        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();

        // 1. Get Total Products
        $totalProducts = $productModel->countAllResults();

        // 2. Get Total Stock across all variants
        $totalStockQuery = $variantModel->selectSum('stock_quantity')->first();
        $totalStock = $totalStockQuery['stock_quantity'] ?? 0;

        // 3. Get Low Stock Alerts
        $lowStockItems = $variantModel->select('product_variants.*, products.name as product_name')
                                      ->join('products', 'products.id = product_variants.product_id', 'left')
                                      ->where('stock_quantity <=', 5)
                                      ->orderBy('stock_quantity', 'ASC')
                                      ->findAll();

        // 4. Get Recent Activity (Last 5 stock movements)
        $recentActivity = $logModel->select('stock_logs.*, products.name as product_name, product_variants.size, product_variants.color')
                                   ->join('products', 'products.id = stock_logs.product_id', 'left')
                                   ->join('product_variants', 'product_variants.id = stock_logs.variant_id', 'left')
                                   ->orderBy('stock_logs.created_at', 'DESC')
                                   ->limit(5)
                                   ->findAll();

        // 5. Daily Sales for the last 7 days
        $db = \Config\Database::connect();
        $dailySales = $db->query("
            SELECT DATE(created_at) as sale_date, SUM(total_amount) as total
            FROM orders
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at)
            ORDER BY sale_date ASC
        ")->getResultArray();

        $salesLabels = [];
        $salesData   = [];
        foreach ($dailySales as $row) {
            $salesLabels[] = date('M d', strtotime($row['sale_date']));
            $salesData[]   = (float) $row['total'];
        }

        // 6. Top 5 Selling Products
        $topProducts = $db->query("
            SELECT products.name, SUM(order_items.quantity) as total_sold
            FROM order_items
            JOIN products ON products.id = order_items.product_id
            GROUP BY order_items.product_id
            ORDER BY total_sold DESC
            LIMIT 5
        ")->getResultArray();

        $topProductLabels = [];
        $topProductData   = [];
        foreach ($topProducts as $row) {
            $topProductLabels[] = $row['name'];
            $topProductData[]   = (int) $row['total_sold'];
        }

        $data = array_merge($this->data, [
            'title'             => 'Dashboard',
            'totalProducts'     => $totalProducts,
            'totalStock'        => $totalStock,
            'lowStockItems'     => $lowStockItems,
            'recentActivity'    => $recentActivity,
            'salesLabels'       => json_encode($salesLabels),
            'salesData'         => json_encode($salesData),
            'topProductLabels'  => json_encode($topProductLabels),
            'topProductData'    => json_encode($topProductData),
        ]);

        return view('pages/dashboard/index', $data);
    }
}