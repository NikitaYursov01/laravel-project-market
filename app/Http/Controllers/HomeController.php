<?php

namespace App\Http\Controllers;

use App\Services\Functions;

class HomeController extends Controller
{
    /**
     * Главная страница с последними заказами
     */
    public function index()
    {
        $latestOrders = Functions::getLatestOrders(6);
        $stats = Functions::getOrdersStats();
        $categories = Functions::getCategoriesWithCount();

        return view('home', compact('latestOrders', 'stats', 'categories'));
    }
}
