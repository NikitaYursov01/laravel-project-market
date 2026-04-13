@extends('componet.shablon')

@section('title', 'Исполнители')

@section('content')

    @include('componet/content.header')

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Исполнители</h1>
                <p class="text-gray-600 mt-1">Найдено: {{ $total }} специалистов</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
                <form method="GET" action="{{ route('performers.index') }}" class="flex gap-3">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Поиск исполнителей</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Например: разработка сайта, дизайн логотипа, реклама..."
                                class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fa fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                            Найти
                        </button>
                    </div>
                </form>

                @if($search)
                    <div class="mt-3">
                        <a href="{{ route('performers.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            <i class="fa fa-times"></i> Сбросить
                        </a>
                    </div>
                @endif
            </div>

            @if(count($performers) === 0)
                <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="text-6xl mb-4">👤</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Исполнители не найдены</h3>
                    <p class="text-gray-600 mb-4">Попробуйте изменить параметры поиска</p>
                    <a href="{{ route('performers.index') }}"
                        class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Показать всех
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($performers as $performer)
                        <div
                            class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-5 flex flex-col">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-12 h-12 {{ $performer['avatar_color'] }} rounded-full flex items-center justify-center text-white font-bold">
                                    {{ $performer['initials'] }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="font-semibold text-gray-900 truncate">{{ $performer['name'] }}</div>
                                        <div class="text-sm text-yellow-500 whitespace-nowrap">★
                                            {{ number_format($performer['rating'], 1) }}
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600">{{ $performer['specialization'] }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $performer['reviews'] }} отзывов</div>
                                </div>
                            </div>

                            <div class="mt-4 text-sm text-gray-600 line-clamp-2">{{ $performer['tasks'] }}</div>

                            <div class="mt-3 flex flex-wrap gap-1">
                                @foreach(array_slice($performer['skills'], 0, 5) as $skill)
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{{ $skill }}</span>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div class="text-lg font-bold text-blue-600">
                                    {{ number_format($performer['hourly_rate'], 0, '', ' ') }} ₽/час
                                </div>
                                <a href="{{ route('chats.index') }}"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                                    Написать
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($lastPage > 1)
                    <div class="mt-8 flex justify-center">
                        <nav class="flex items-center gap-1">
                            @php
                                $query = [];
                                if ($search)
                                    $query['search'] = $search;
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($currentPage > 1)
                                <a href="{{ route('performers.index', array_merge($query, ['page' => $currentPage - 1])) }}"
                                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">←</a>
                            @endif

                            @if($start > 1)
                                <a href="{{ route('performers.index', array_merge($query, ['page' => 1])) }}"
                                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">1</a>
                                @if($start > 2)
                                    <span class="px-2 text-gray-400">...</span>
                                @endif
                            @endif

                            @for($i = $start; $i <= $end; $i++)
                                @if($i === $currentPage)
                                    <span class="px-3 py-2 bg-blue-600 text-white rounded-lg">{{ $i }}</span>
                                @else
                                    <a href="{{ route('performers.index', array_merge($query, ['page' => $i])) }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">{{ $i }}</a>
                                @endif
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="px-2 text-gray-400">...</span>
                                @endif
                                <a href="{{ route('performers.index', array_merge($query, ['page' => $lastPage])) }}"
                                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">{{ $lastPage }}</a>
                            @endif

                            @if($currentPage < $lastPage)
                                <a href="{{ route('performers.index', array_merge($query, ['page' => $currentPage + 1])) }}"
                                    class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">→</a>
                            @endif
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection