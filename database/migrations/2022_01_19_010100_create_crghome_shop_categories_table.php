<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_categories';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.categories', $this->table))){
            Schema::create(config('crghome-shop.db.tables.categories', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('category_id')->nullable()->constrained(config('crghome-shop.db.tables.categories', $this->table))->onUpdate('cascade')->onDelete('set null');
                $table->string('name', 255);
                $table->string('title', 255)->nullable();
                $table->string('alias', 255);
                $table->string('path', 255);
                $table->text('prevText')->nullable();
                $table->longText('fullText')->nullable();
                $table->json('images')->nullable();
                $table->json('meta')->nullable();
                $table->dateTime('dateBeginPub')->nullable();
                $table->dateTime('dateEndPub')->nullable();
                // config
                $table->boolean('hide')->default(false);
                $table->integer('order')->default(999);
                $table->boolean('showPrevText')->default(false);
                // statistics
                $table->integer('views')->default(0);
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
        Schema::dropIfExists(config('crghome-shop.db.tables.categories', $this->table));
    }
};
