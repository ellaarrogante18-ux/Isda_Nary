<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fish_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity_sold', 8, 2);
            $table->decimal('price_per_kilo', 8, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('customer_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('sale_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
