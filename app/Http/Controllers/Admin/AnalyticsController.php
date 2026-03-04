<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        // Yearly Sales Data (last 8 years)
        $yearlySalesData = DB::table('orders as o')
            ->select(DB::raw('YEAR(o.created_at) as year'), DB::raw('SUM(oi.quantity * oi.price) as total_sales'))
            ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
            ->where('o.payment_status', 'Paid')
            ->where('o.created_at', '>=', now()->subYears(8))
            ->groupBy(DB::raw('YEAR(o.created_at)'))
            ->orderBy('year')
            ->get();

        // Monthly Sales Data (current year)
        $monthlySalesData = DB::table('orders as o')
            ->select(DB::raw('MONTH(o.created_at) as month'), DB::raw('MONTHNAME(o.created_at) as month_name'), DB::raw('SUM(oi.quantity * oi.price) as total_sales'))
            ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
            ->where('o.payment_status', 'Paid')
            ->whereYear('o.created_at', now()->year)
            ->groupBy(DB::raw('MONTH(o.created_at), MONTHNAME(o.created_at)'))
            ->orderBy('month')
            ->get();

        // Date Range Sales Data
        $dateRangeSalesData = DB::table('orders as o')
            ->select(DB::raw('DATE(o.created_at) as date'), DB::raw('SUM(oi.quantity * oi.price) as total_sales'))
            ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
            ->where('o.payment_status', 'Paid')
            ->whereBetween(DB::raw('DATE(o.created_at)'), [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(o.created_at)'))
            ->orderBy('date')
            ->get();

        // Product Sales — raw data passed to Blade for vanilla Chart.js pie rendering.
        // ConsoleTVs crashes (Array to string) when backgroundColor is an array,
        // so we skip the library for this chart entirely.
        $productSalesData = DB::table('order_items as oi')
            ->select('p.product_name', DB::raw('SUM(oi.quantity * oi.price) as total_sales'))
            ->join('products as p', 'oi.product_id', '=', 'p.product_id')
            ->join('orders as o', 'oi.order_id', '=', 'o.order_id')
            ->where('o.payment_status', 'Paid')
            ->groupBy('p.product_id', 'p.product_name')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        $totalProductSales = $productSalesData->sum('total_sales');
        $pieLabels      = $productSalesData->pluck('product_name');
        $piePercentages = $productSalesData->map(fn($i) => $totalProductSales > 0
            ? round(($i->total_sales / $totalProductSales) * 100, 2) : 0);

        // ConsoleTVs Charts v6 — line/bar only.
        // Use ->options([]) on dataset instead of ->color() / ->backgroundcolor()
        // because those cast values to string and crash when given an array.

        $yearlySalesChart = new Chart;
        $yearlySalesChart->labels($yearlySalesData->pluck('year')->toArray());
        $yearlySalesChart->dataset('Sales (₱)', 'line', $yearlySalesData->pluck('total_sales')->toArray())
            ->options(['borderColor' => '#0a0a0a', 'backgroundColor' => 'rgba(10, 10, 10, 0.1)', 'fill' => true, 'tension' => 0.4]);
        $yearlySalesChart->options(['responsive' => true]);

        $monthlySalesChart = new Chart;
        $monthlySalesChart->labels($monthlySalesData->pluck('month_name')->toArray());
        $monthlySalesChart->dataset('Sales (₱)', 'bar', $monthlySalesData->pluck('total_sales')->toArray())
            ->options(['borderColor' => '#FFB6C1', 'backgroundColor' => 'rgba(255, 182, 193, 0.6)']);
        $monthlySalesChart->options(['responsive' => true]);

        $dateRangeSalesChart = new Chart;
        $dateRangeSalesChart->labels($dateRangeSalesData->pluck('date')->toArray());
        $dateRangeSalesChart->dataset('Sales (₱)', 'bar', $dateRangeSalesData->pluck('total_sales')->toArray())
            ->options(['borderColor' => '#1a1a1a', 'backgroundColor' => 'rgba(26, 26, 26, 0.6)']);
        $dateRangeSalesChart->options(['responsive' => true]);

        return view('admin.analytics', compact(
            'yearlySalesChart', 'monthlySalesChart', 'dateRangeSalesChart',
            'pieLabels', 'piePercentages', 'startDate', 'endDate'
        ));
    }
}