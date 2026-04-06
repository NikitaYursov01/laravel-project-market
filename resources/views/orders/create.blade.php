@extends('componet.shablon')

<!-- HEAD ADD CONTENT -->
@section('title', 'Создание заказа')
@section('description', 'C')

<!-- BODY CONTENT -->
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Разместить новое объявление/услугу/заказ</h2>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <strong>Ошибки:</strong>
                <ul class="mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Order Name -->
            <div>
                <label for="order_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Название заказа <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="order_name" 
                    name="order_name" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('order_name') border-red-500 @enderror"
                    placeholder="Введите название заказа"
                    value="{{ old('order_name') }}"
                >
                @error('order_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Категория <span class="text-red-500">*</span>
                </label>
                <select 
                    id="category" 
                    name="category" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('category') border-red-500 @enderror"
                >
                    <option value="">Выберите категорию</option>
                    <option value="programming" {{ old('category') == 'programming' ? 'selected' : '' }}>Программирование</option>
                    <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>Дизайн</option>
                    <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Маркетинг</option>
                    <option value="writing" {{ old('category') == 'writing' ? 'selected' : '' }}>Копирайтинг</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Другое</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Budget -->
            <div>
                <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                    Бюджет <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="budget" 
                    name="budget" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('budget') border-red-500 @enderror"
                    placeholder="Укажите бюджет"
                    value="{{ old('budget') }}"
                >
                @error('budget')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Описание заказа <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    required
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none @error('description') border-red-500 @enderror"
                    placeholder="Подробно опишите, что нужно сделать"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Materials -->
            <div>
                <label for="materials" class="block text-sm font-medium text-gray-700 mb-2">
                    Материалы
                </label>
                <textarea 
                    id="materials" 
                    name="materials" 
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none @error('materials') border-red-500 @enderror"
                    placeholder="Укажите, какие материалы предоставите или какие нужны"
                >{{ old('materials') }}</textarea>
                @error('materials')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                    Местоположение
                </label>
                <input 
                    type="text" 
                    id="location" 
                    name="location"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('location') border-red-500 @enderror"
                    placeholder="Город, адрес (если важна геолокация)"
                    value="{{ old('location') }}"
                >
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Completion Date -->
            <div>
                <label for="completion_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Срок выполнения <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    id="completion_date" 
                    name="completion_date" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('completion_date') border-red-500 @enderror"
                    value="{{ old('completion_date') }}"
                >
                @error('completion_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Technical Requirements -->
            <div>
                <label for="technical_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                    Технические требования
                </label>
                <textarea 
                    id="technical_requirements" 
                    name="technical_requirements" 
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none @error('technical_requirements') border-red-500 @enderror"
                    placeholder="Особые требования, технологии, формат и т.д."
                >{{ old('technical_requirements') }}</textarea>
                @error('technical_requirements')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Изображения
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="font-medium">Нажмите для загрузки</span> или перетащите файлы
                    </p>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF до 10MB</p>
                    <input type="file" class="hidden" accept="image/*" multiple name="images[]">
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="flex space-x-4 pt-6">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                >
                    Разместить заказ
                </button>
                <button 
                    type="button" 
                    onclick="window.history.back()"
                    class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors font-medium"
                >
                    Отмена
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="bg-blue-50 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Советы по созданию заказа</h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div class="space-y-2">
                <p>• <strong>Четкое название:</strong> Используйте понятные и конкретные формулировки</p>
                <p>• <strong>Детальное описание:</strong> Чем больше деталей, тем лучше результат</p>
                <p>• <strong>Реалистичный бюджет:</strong> Исследуйте рыночные цены</p>
            </div>
            <div class="space-y-2">
                <p>• <strong>Четкие сроки:</strong> Укажите реалистичные даты выполнения</p>
                <p>• <strong>Технические детали:</strong> Укажите все важные требования</p>
                <p>• <strong>Визуальные материалы:</strong> Добавьте изображения для наглядности</p>
            </div>
        </div>
    </div>
</div>
@endsection
