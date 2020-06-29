<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbacks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id')->index()->nullable()->unsigned();
            $table->double('client_cashback')->default(0.00);
            $table->double('zerocach_cashback')->default(0.00);
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents')
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
        Schema::dropIfExists('cashbacks');
        Schema::table('cashbacks', function (Blueprint $table) {
            $table->dropForeign('cashbacks_agent_id_foreign');
        });
    }
}
