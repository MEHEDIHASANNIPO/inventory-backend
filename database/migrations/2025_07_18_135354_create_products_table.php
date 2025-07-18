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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('ware_houses')->onDelete('cascade');
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('product_code');
            $table->decimal('original_price', 10, 2)->default(0);
            $table->decimal('sell_price', 10, 2)->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->longText('description')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
