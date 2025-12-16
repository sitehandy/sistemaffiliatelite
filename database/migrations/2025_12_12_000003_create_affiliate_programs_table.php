<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliate_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('program_type', ['sale', 'view', 'lead']);
            $table->enum('commission_type', ['flat', 'percentage']);
            $table->decimal('commission_amount', 10, 2);
            $table->enum('visibility', ['hidden', 'open'])->default('open');
            $table->string('invitation_code')->nullable()->unique();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_programs');
    }
};
