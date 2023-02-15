<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_statuses';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.statuses', $this->table))){
            Schema::create(config('crghome-shop.db.tables.statuses', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type_status', 150);
                $table->string('code', 10)->unique();
                $table->string('name', 150);
                $table->json('images')->nullable();
                $table->string('icon_class')->nullable();
                $table->text('icon_base')->nullable();
                $table->integer('order')->default(999);
                $table->text('remark')->nullable();
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
        Schema::dropIfExists(config('crghome-shop.db.tables.statuses', $this->table));
    }
};
