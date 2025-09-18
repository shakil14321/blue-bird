<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('status')->default('Pending')->after('address');
            $table->date('event_date')->nullable()->after('status');
            $table->decimal('budget', 12, 2)->nullable()->after('event_date');
            $table->decimal('discount', 5, 2)->nullable()->after('budget'); // percent
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['status', 'event_date', 'budget', 'discount']);
        });
    }
};
