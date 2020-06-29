<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->bigInteger('type_id')->nullable()->unsigned();
            $table->string('business_name');
            $table->string('business_logo')->nullable();
            $table->double('cashback')->default(0.00); //removed from table as column and append fro model / value is summation two column from cashbacks table which aer (client_cashback,zerocach_cashback)
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('no action');
            $table->foreign('type_id')->references('id')->on('types')
                ->onDelete('set null')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropForeign('agents_user_id_foreign');
            $table->dropForeign('agents_type_id_foreign');
        });
        Schema::dropIfExists('agents');
    }
}
