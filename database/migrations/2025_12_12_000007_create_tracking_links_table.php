<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('affiliate_programs')->cascadeOnDelete();
            $table->string('unique_code', 32)->unique();
            $table->string('tracking_url');
            $table->timestamps();

            $table->unique(['user_id', 'product_id', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_links');
    }
};
