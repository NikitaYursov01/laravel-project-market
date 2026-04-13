<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('path'); // путь к файлу
            $table->string('original_name')->nullable(); // оригинальное имя файла
            $table->integer('order')->default(0); // порядок сортировки
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_images');
    }
};
