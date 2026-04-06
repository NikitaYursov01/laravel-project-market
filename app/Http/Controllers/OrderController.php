<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Показать форму создания заказа
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Сохранить новый заказ
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validator = Validator::make($request->all(), [
            'order_name' => 'required|string|max:255',
            'category' => 'required|string|in:programming,design,marketing,writing,other',
            'budget' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'materials' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'required|date|after:today',
            'technical_requirements' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // до 10MB
        ], [
            'order_name.required' => 'Название заказа обязательно для заполнения',
            'order_name.max' => 'Название заказа не должно превышать 255 символов',
            'category.required' => 'Выберите категорию',
            'category.in' => 'Выбрана недопустимая категория',
            'budget.required' => 'Укажите бюджет',
            'budget.max' => 'Бюджет не должен превышать 100 символов',
            'description.required' => 'Описание заказа обязательно',
            'description.min' => 'Описание должно содержать минимум 10 символов',
            'completion_date.required' => 'Укажите срок выполнения',
            'completion_date.date' => 'Укажите корректную дату',
            'completion_date.after' => 'Срок выполнения должен быть позже сегодняшней даты',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы: JPEG, PNG, JPG, GIF',
            'images.*.max' => 'Размер изображения не должен превышать 10MB',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('orders.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Здесь будет логика сохранения заказа в базу данных
        // $order = Order::create([
        //     'name' => $request->order_name,
        //     'category' => $request->category,
        //     'budget' => $request->budget,
        //     'description' => $request->description,
        //     'materials' => $request->materials,
        //     'location' => $request->location,
        //     'completion_date' => $request->completion_date,
        //     'technical_requirements' => $request->technical_requirements,
        //     'user_id' => auth()->id(),
        // ]);

        // Обработка изображений
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // $path = $image->store('orders', 'public');
                // OrderImage::create([
                //     'order_id' => $order->id,
                //     'image_path' => $path,
                // ]);
            }
        }

        // Временно сохраняем в сессию для демонстрации
        session([
            'order_data' => $request->except(['images']),
            'order_timestamp' => now(),
            'success_message' => 'Заказ успешно размещен! ID: ' . uniqid('ORDER_'),
        ]);

        return redirect()
            ->route('orders.create')
            ->with('success', 'Заказ успешно размещен!');
    }

    /**
     * Показать ленту заказов
     */
    public function feed()
    {
        // Здесь будет логика получения заказов из базы
        // $orders = Order::with('user')->latest()->paginate(10);
        
        return view('orders.feed');
    }

    /**
     * Показать мои заказы
     */
    public function my()
    {
        // Здесь будет логика получения заказов текущего пользователя
        // $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        
        return view('orders.my');
    }

    /**
     * Показать детальную страницу заказа
     */
    public function detail($id)
    {
        // Здесь будет логика получения конкретного заказа
        // $order = Order::with(['user', 'images'])->findOrFail($id);
        
        return view('orders.detail', ['orderId' => $id]);
    }
}
