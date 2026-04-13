<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_performer')->default(false)->after('password');
            $table->string('specialization')->nullable()->after('is_performer');
            $table->text('skills')->nullable()->after('specialization');
            $table->text('about')->nullable()->after('skills');
            $table->unsignedInteger('hourly_rate')->nullable()->after('about');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_performer', 'specialization', 'skills', 'about', 'hourly_rate']);
        });
    }
};
