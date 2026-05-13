<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Sales extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $db         = \Config\Database::connect();

        $dateFrom = $this->request->getGet('date_from') ?? date('Y-m-01');
        $dateTo   = $this->request->getGet('date_to')   ?? date('Y-m-d');

        $orders = $orderModel
            ->where('DATE(created_at) >=', $dateFrom)
            ->where('DATE(created_at) <=', $dateTo)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Total revenue for the period
        $totalRevenue = array_sum(array_column($orders, 'total_amount'));

        // Top selling products for the period
        $topProducts = $db->query("
            SELECT products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as revenue
            FROM order_items
            JOIN orders ON orders.id = order_items.order_id
            JOIN products ON products.id = order_items.product_id
            WHERE DATE(orders.created_at) >= '{$dateFrom}'
            AND DATE(orders.created_at) <= '{$dateTo}'
            GROUP BY order_items.product_id
            ORDER BY total_sold DESC
            LIMIT 5
        ")->getResultArray();

        $data = array_merge($this->data ?? [], [
            'title'        => 'Sales Reports',
            'orders'       => $orders,
            'totalRevenue' => $totalRevenue,
            'topProducts'  => $topProducts,
            'dateFrom'     => $dateFrom,
            'dateTo'       => $dateTo,
        ]);

        return view('pages/sales/index', $data);
    }

    public function show($id)
    {
        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $order = $orderModel->find($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $items = $orderItemModel
            ->select('order_items.*, products.name as product_name, product_variants.sku, product_variants.size, product_variants.color')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->join('product_variants', 'product_variants.id = order_items.variant_id', 'left')
            ->where('order_id', $id)
            ->findAll();

        $data = array_merge($this->data ?? [], [
            'title' => 'Order Detail — ' . $order['order_number'],
            'order' => $order,
            'items' => $items
        ]);

        return view('pages/sales/show', $data);
    }
}