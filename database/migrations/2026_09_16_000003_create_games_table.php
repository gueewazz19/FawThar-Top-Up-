<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('slug', 160)->unique();
            $table->text('description')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('banner', 255)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('requires_user_id')->default(true);
            $table->boolean('requires_server_id')->default(false);
            $table->string('user_id_label', 100)->default('User ID / Player ID');
            $table->string('server_id_label', 100)->nullable()->default('Zone ID / Server ID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
