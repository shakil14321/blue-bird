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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // usigned big integer
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subcategories_id')->nullable();
            $table->integer('quantity')->default(1);
            // foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subcategories_id')->references('id')->on('subcategories')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // disable foreign key checks to avoid issues during rollback
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('carts');
        Schema::enableForeignKeyConstraints();
    }
};
