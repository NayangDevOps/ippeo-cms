<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug', 191)->unique();
            $table->string('sku', 191)->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);

            // Content
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('ingredients')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('usage_guide')->nullable();

            // Media
            $table->string('featured_image')->nullable();

            // Status flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_active')->default(true);

            // Stats
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
