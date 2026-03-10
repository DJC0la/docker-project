<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id(); // Автоинкрементный первичный ключ
            $table->string('name'); // Название организации
            $table->string('website')->nullable(); // Ссылка на сайт (может быть null)
            $table->string('rector_id')->nullable(); // Ректор (может быть null)
            $table->string('address')->nullable(); // Адрес (может быть null)
            $table->string('email')->nullable(); // Почта (может быть null)
            $table->string('telephone')->nullable(); // Телефон (может быть null)
            $table->string('department')->nullable(); // Ведомство (может быть null)
            $table->timestamps(); // created_at и updated_at
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};