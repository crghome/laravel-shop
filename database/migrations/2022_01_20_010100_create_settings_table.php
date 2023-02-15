<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_settings';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.settings', $this->table))){
            Schema::create(config('crghome-shop.db.tables.settings', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('prevText')->nullable();
                $table->longText('fullText')->nullable();
                $table->json('images')->nullable();
                $table->json('pictures')->nullable();
                $table->string('suffixPrice')->nullable();
                $table->json('meta')->nullable();
                // config
                $table->boolean('noAuthOfBuy')->default(true);
                $table->boolean('countNullProductOfBuy')->default(true);
                $table->boolean('showPrevText')->default(false);
                $table->boolean('showSuffixPrice')->default(false);
                // statistics
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
        Schema::dropIfExists(config('crghome-shop.db.tables.settings', $this->table));
    }
};
