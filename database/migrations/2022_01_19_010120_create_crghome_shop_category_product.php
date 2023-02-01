<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_category_products';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.category_products', $this->table))){
            Schema::create(config('crghome-shop.db.tables.category_products', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('category_id')->nullable()->constrained(config('crghome-shop.db.tables.categories', 'crgshop_categories'))->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained(config('crghome-shop.db.tables.products', 'crgshop_products'))->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('created_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
                $table->foreignId('updated_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('crghome-shop.db.tables.category_products', $this->table));
    }
};
