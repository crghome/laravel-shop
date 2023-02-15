<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_carts';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.carts', $this->table))){
            Schema::create(config('crghome-shop.db.tables.carts', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('product_id')->constrained(config('crghome-shop.db.tables.products'))->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_id')->constrained(config('crghome-shop.db.tables.clients'))->onUpdate('cascade')->onDelete('cascade');
                $table->integer('count');
                // statistics
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
        Schema::dropIfExists(config('crghome-shop.db.tables.carts', $this->table));
    }
};
