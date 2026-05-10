<!-- это html шаблон вставляем -->


<!-- HEAD ADD CONTENT -->
<?php $__env->startSection('title', 'Название страницы TITLE'); ?>
<?php $__env->startSection('description','Описание страницы DESCRIPTION'); ?>

<!-- BODY CONTENT -->
<?php $__env->startSection('content'); ?>

<div class="w-full h-screen bg-gray-100 flex items-center justify-center p-4">
    <!-- Mobile: Full screen, Tablet/Desktop: Max width -->
    <div class="w-full max-w-2xl h-full bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:max-w-4xl lg:max-w-5xl">
    <!-- Header -->
    <div class="bg-gray-800 text-white p-3 md:p-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center space-x-2 md:space-x-3">
            <!-- Back arrow -->
            <svg class="w-5 h-5 md:w-6 md:h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            
            <!-- User avatar -->
            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-500 rounded-full flex items-center justify-center font-bold text-sm md:text-base">
                P
            </div>
            
            <!-- User info -->
            <div>
                <div class="font-semibold text-sm md:text-base">Роман Катин</div>
                <div class="text-xs text-green-400">В сети</div>
            </div>
        </div>
        
        <!-- Action icons -->
        <div class="flex items-center space-x-2 md:space-x-3">
            <svg class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <svg class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <svg class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
        </div>
    </div>

    <!-- Active Task Section -->
    <div class="bg-gray-50 p-3 md:p-4 border-b flex-shrink-0">
        <div class="text-xs text-gray-500 font-semibold mb-2">АКТИВНАЯ ЗАДАЧА</div>
        <div class="bg-white rounded-lg p-3 shadow-sm">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-2">
                <div class="mb-2 md:mb-0">
                    <div class="font-medium text-sm">Разработка детали</div>
                    <div class="flex items-center mt-1">
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs text-green-600">В работе</span>
                    </div>
                </div>
                <div class="text-blue-600 font-bold text-sm">61%</div>
            </div>
            
            <!-- Progress bars -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-600">Бюджет</span>
                        <span class="text-xs font-medium">150 000 P</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 61%"></div>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-600">Дедлайн</span>
                        <span class="text-xs font-medium">150 000 P</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 61%"></div>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-600">Детали</span>
                        <span class="text-xs font-medium">150 000 P</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 61%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto p-3 md:p-4 space-y-4">
        <!-- Date separator -->
        <div class="text-center">
            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">6 марта 2026</span>
        </div>

        <!-- Message from A (left side) -->
        <div class="flex items-start space-x-2 md:space-x-3">
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gray-300 rounded-full flex items-center justify-center text-xs md:text-sm font-bold flex-shrink-0">
                A
            </div>
            <div class="max-w-xs md:max-w-md lg:max-w-lg">
                <div class="bg-gray-100 rounded-lg p-3">
                    <p class="text-sm text-gray-800">Добрый день! Я ознакомился с техническим заданием и готов приступить к работе. У меня есть несколько уточняющих вопросов.</p>
                </div>
                <div class="text-xs text-gray-500 mt-1">10:30</div>
            </div>
        </div>

        <!-- Message from P (right side) -->
        <div class="flex items-start space-x-2 md:space-x-3 justify-end">
            <div class="max-w-xs md:max-w-md lg:max-w-lg">
                <div class="bg-blue-500 text-white rounded-lg p-3">
                    <p class="text-sm">Добрый день! Я ознакомился с техническим заданием и готов приступить к работе. У меня есть несколько уточняющих вопросов.</p>
                </div>
                <div class="text-xs text-gray-500 mt-1 text-right">10:30</div>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-500 rounded-full flex items-center justify-center text-xs md:text-sm font-bold text-white flex-shrink-0">
                P
            </div>
        </div>
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t p-3 md:p-4 flex-shrink-0">
        <div class="flex items-center space-x-2 md:space-x-3">
            <!-- Attachment icon -->
            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-500 cursor-pointer flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
            </svg>
            
            <!-- Image icon -->
            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-500 cursor-pointer flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            
            <!-- Input field -->
            <input type="text" placeholder="Введите сообщение..." class="flex-1 px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500 text-sm">
            
            <!-- Microphone icon -->
            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-500 cursor-pointer flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('componet/shablon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Huawei Matebook\Desktop\Проект\laravel-project-market\resources\views/Hello.blade.php ENDPATH**/ ?>