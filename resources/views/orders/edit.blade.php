@extends('componet.shablon')

@section('title', 'Редактирование заказа — ' . $order->title)

@use(App\Services\Functions)

@section('content')

    @include('componet/content.header')

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Редактировать объявление</h2>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ Functions::getOrderTypeLabel($order->type) }}
                </span>
            </div>

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

            <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-6"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Order Name -->
                <div>
                    <label for="order_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Название заказа <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="order_name" name="order_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('order_name') border-red-500 @enderror"
                        placeholder="Введите название заказа" value="{{ old('order_name', $order->title) }}">
                    @error('order_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Категория металлопроката <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('category') border-red-500 @enderror">
                        <option value="">Выберите категорию</option>
                        <option value="metal_sheet" {{ old('category', $order->category) == 'metal_sheet' ? 'selected' : '' }}>Листовой металл</option>
                        <option value="metal_pipe" {{ old('category', $order->category) == 'metal_pipe' ? 'selected' : '' }}>
                            Трубы металлические</option>
                        <option value="metal_beam" {{ old('category', $order->category) == 'metal_beam' ? 'selected' : '' }}>
                            Балки / Швеллер</option>
                        <option value="metal_rebar" {{ old('category', $order->category) == 'metal_rebar' ? 'selected' : '' }}>Арматура / Сетка</option>
                        <option value="metal_wire" {{ old('category', $order->category) == 'metal_wire' ? 'selected' : '' }}>
                            Проволока / Канаты</option>
                        <option value="metal_processing" {{ old('category', $order->category) == 'metal_processing' ? 'selected' : '' }}>Обработка металла</option>
                        <option value="metal_products" {{ old('category', $order->category) == 'metal_products' ? 'selected' : '' }}>Металлические изделия</option>
                        <option value="delivery" {{ old('category', $order->category) == 'delivery' ? 'selected' : '' }}>
                            Доставка / Логистика</option>
                        <option value="other" {{ old('category', $order->category) == 'other' ? 'selected' : '' }}>Другое
                        </option>
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
                    <input type="text" id="budget" name="budget" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('budget') border-red-500 @enderror"
                        placeholder="Укажите бюджет" value="{{ old('budget', $order->budget) }}">
                    @error('budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Описание заказа <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" required rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none @error('description') border-red-500 @enderror"
                        placeholder="Подробно опишите, что нужно сделать">{{ old('description', $order->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Materials -->
                <div>
                    <label for="materials" class="block text-sm font-medium text-gray-700 mb-2">
                        Материалы
                    </label>
                    <textarea id="materials" name="materials" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none @error('materials') border-red-500 @enderror"
                        placeholder="Укажите, какие материалы предоставите или какие нужны">{{ old('materials', $order->materials) }}</textarea>
                    @error('materials')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Местоположение
                    </label>
                    <input type="text" id="location" name="location"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('location') border-red-500 @enderror"
                        placeholder="Город, адрес (если важна геолокация)" value="{{ old('location', $order->location) }}">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Completion Date -->
                <div>
                    <label for="completion_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Срок выполнения <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="completion_date" name="completion_date" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('completion_date') border-red-500 @enderror"
                        value="{{ old('completion_date', $order->completion_date?->format('Y-m-d')) }}">
                    @error('completion_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technical Requirements -->
                <div>
                    <label for="technical_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                        Технические требования
                    </label>
                    <textarea id="technical_requirements" name="technical_requirements" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none @error('technical_requirements') border-red-500 @enderror"
                        placeholder="Особые требования, технологии, формат и т.д.">{{ old('technical_requirements', $order->technical_requirements) }}</textarea>
                    @error('technical_requirements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Images -->
                @if($order->images && $order->images->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Текущие изображения ({{ $order->images->count() }})
                        </label>
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @foreach($order->images as $image)
                                <div class="relative group">
                                    <img src="{{ $image->getUrl() }}" alt="{{ $image->original_name }}"
                                        class="w-full h-24 object-cover rounded-lg border">
                                    <span
                                        class="absolute top-1 right-1 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-75">{{ $loop->iteration }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Add New Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Добавить изображения
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors cursor-pointer"
                        onclick="document.getElementById('images').click()">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-medium">Нажмите для загрузки</span> новых изображений
                        </p>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF до 10MB (до 5 файлов)</p>
                        <input type="file" id="images" class="hidden" accept="image/*" multiple name="images[]"
                            onchange="previewImages(this)">
                    </div>
                    <div id="image-preview" class="grid grid-cols-3 gap-2 mt-4"></div>
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Buttons -->
                <div class="flex space-x-4 pt-6">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fa fa-save mr-2"></i>Сохранить изменения
                    </button>
                    <a href="{{ route('orders.my') }}"
                        class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImages(input) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach((file, index) => {
                    if (index >= 5) return; // Максимум 5 изображений

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border">
                                <span class="absolute top-1 right-1 bg-green-600 text-white text-xs px-2 py-1 rounded">NEW ${index + 1}</span>
                            `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });

                if (input.files.length > 5) {
                    alert('Можно загрузить максимум 5 изображений за раз');
                }
            }
        }
    </script>
@endsection