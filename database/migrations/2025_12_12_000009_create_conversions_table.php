<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracking_event_id')->constrained('tracking_events')->cascadeOnDelete();
            $table->decimal('conversion_value', 12, 2)->default(0);
            $table->json('conversion_data')->nullable();
            $table->string('order_id')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};
