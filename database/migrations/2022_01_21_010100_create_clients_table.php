<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'crgshop_clients';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable(config('crghome-shop.db.tables.clients', $this->table))){
            Schema::create(config('crghome-shop.db.tables.clients', $this->table), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('login', 150);
                $table->string('name', 150);
                $table->string('phone', 20);
                $table->string('email', 50)->nullable();
                $table->string('company', 255)->nullable();
                $table->text('address')->nullable();
                $table->text('remark')->nullable();
                $table->string('phone_verified_code')->nullable();
                $table->timestamp('phone_verified_at')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 255);
                $table->json('images')->nullable();
                $table->boolean('accessed', 255)->default(true);
                $table->boolean('moderated', 255)->default(false);
                $table->dateTime('last_used_at')->nullable();
                $table->boolean('subs_news')->default(false);
                $table->boolean('subs_actions')->default(false);
                $table->boolean('subs_push')->nullable();
                // statistics
                $table->foreignId('created_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
                $table->foreignId('updated_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists(config('crghome-shop.db.tables.clients', $this->table));
    }
};
