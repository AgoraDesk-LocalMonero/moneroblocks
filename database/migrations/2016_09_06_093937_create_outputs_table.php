<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vout', function (Blueprint $table) {
          $table->engine = 'MYISAM';

          $table->unsignedBigInteger('bl_height');
          $table->unsignedBigInteger('txid');
          $table->unsignedBigInteger('voutid');
          $table->unsignedBigInteger('amount');
          $table->unsignedBigInteger('true_amount')->nullable();
          $table->unsignedBigInteger('global_index');
          $table->string('public_key',128);
          $table->unsignedBigInteger('amount_index');

          $table->index(['bl_height', 'txid', 'voutid']);
          $table->primary(['amount', 'amount_index']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vout');
    }
}
