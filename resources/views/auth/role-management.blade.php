@extends('componet.shablon')

@section('title', 'Управление ролями — Админ панель')
@section('description', 'Управление ролями пользователей DetailDeal')

@section('content')
    @include('componet/content.header')
    @use(App\Services\Functions)

    <div class="min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Управление ролями</h1>
                        <p class="text-slate-600 mt-1">Назначайте роли пользователям платформы</p>
                    </div>
                    <a href="{{ route('profile') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-medium hover:bg-slate-50 transition-colors">
                        <i class="fa fa-arrow-left"></i>
                        В профиль
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                    <div class="flex items-center gap-2">
                        <i class="fa fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <div class="flex items-center gap-2">
                        <i class="fa fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Search -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                <form action="{{ route('admin.roles.search') }}" method="POST" class="flex gap-3">
                    @csrf
                    <div class="flex-1 relative">
                        <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="q" value="{{ $searchQuery ?? '' }}"
                            placeholder="Поиск по имени или email..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-slate-900 text-white rounded-xl font-medium hover:bg-slate-800 transition-colors">
                        Найти
                    </button>
                    @if(!empty($searchQuery))
                        <a href="{{ route('admin.roles') }}"
                            class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-medium hover:bg-slate-50 transition-colors">
                            Сбросить
                        </a>
                    @endif
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Список пользователей</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Пользователь</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Текущая роль</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Дата регистрации</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Действия</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-700 rounded-xl flex items-center justify-center text-white font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $roleColors = [
                                                'client' => 'bg-blue-100 text-blue-700',
                                                'performer' => 'bg-green-100 text-green-700',
                                                'manager' => 'bg-amber-100 text-amber-700',
                                                'admin' => 'bg-red-100 text-red-700',
                                            ];
                                            $roleLabels = [
                                                'client' => 'Заказчик',
                                                'performer' => 'Исполнитель',
                                                'manager' => 'Менеджер',
                                                'admin' => 'Администратор',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-lg text-sm font-medium {{ $roleColors[$user->role] ?? 'bg-slate-100 text-slate-700' }}">
                                            {{ $roleLabels[$user->role] ?? $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $user->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.role.update', $user) }}" method="POST" class="flex gap-2">
                                                @csrf
                                                <select name="role"
                                                    class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    onchange="this.form.submit()">
                                                    @foreach($roles as $key => $label)
                                                        <option value="{{ $key }}" {{ $user->role === $key ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @else
                                            <span class="text-slate-400 text-sm">Нельзя изменить</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

            <!-- Legend -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="font-medium text-slate-900">Заказчик</span>
                    </div>
                    <p class="text-sm text-slate-600">Размещает заказы на металлопрокат и услуги</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="font-medium text-slate-900">Исполнитель</span>
                    </div>
                    <p class="text-sm text-slate-600">Выполняет заказы, продает металлопрокат</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="font-medium text-slate-900">Менеджер</span>
                    </div>
                    <p class="text-sm text-slate-600">Модерирует чаты и помогает в спорах</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="font-medium text-slate-900">Администратор</span>
                    </div>
                    <p class="text-sm text-slate-600">Полный доступ к управлению платформой</p>
                </div>
            </div>
        </div>
    </div>
@endsection
