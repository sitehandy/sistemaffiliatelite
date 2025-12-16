<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('step');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->text('message')->nullable();
            $table->json('details')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installation_logs');
    }
};
