<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_orders';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.orders', $this->table))){
            Schema::create(config('crghome-shop.db.tables.orders', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('number', 150)->unique();
                $table->foreignId('client_id')->constrained(config('crghome-shop.db.tables.clients'))->onUpdate('cascade')->onDelete('cascade');
                $table->json('products');
                $table->string('client_name', 150);
                $table->string('client_phone', 20);
                $table->string('client_email', 50)->nullable();
                $table->string('client_company', 255)->nullable();
                $table->text('address')->nullable();
                $table->float('amount', 13, 4);
                // statistics
                $table->foreignId('status_id')->constrained(config('crghome-shop.db.tables.statuses'))->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists(config('crghome-shop.db.tables.orders', $this->table));
    }
};
