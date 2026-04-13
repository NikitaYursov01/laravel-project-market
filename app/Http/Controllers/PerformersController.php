<?php

namespace App\Http\Controllers;

use App\Services\Functions;
use Illuminate\Http\Request;

class PerformersController extends Controller
{
    /**
     * Показать список исполнителей
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $specialization = $request->get('specialization', '');
        $page = (int) $request->get('page', 1);

        // Получаем исполнителей через Functions с пагинацией
        $result = Functions::getPerformers(12, $search, $specialization, $page);
        $categories = Functions::getPerformerCategories();

        return view('performers.index', [
            'performers' => $result['data'],
            'total' => $result['total'],
            'perPage' => $result['per_page'],
            'currentPage' => $result['current_page'],
            'lastPage' => $result['last_page'],
            'categories' => $categories,
            'search' => $search,
            'specialization' => $specialization,
        ]);
    }
}
