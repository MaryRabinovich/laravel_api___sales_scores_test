<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigInteger('id')->primary();

            $table->foreignId('client_id')
                ->references('id')->on('users')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->enum('status', [
                'new', 
                'accepted', 
                'shipping'
            ])->default('new');

            $table->integer('scores')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
