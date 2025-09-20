<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('name');
            $table->date('event_date')->nullable();
            $table->string('phone');
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('location');

            $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // disable foreign key checks to avoid issues during drop
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('quotations');
        Schema::enableForeignKeyConstraints();
    }
};
