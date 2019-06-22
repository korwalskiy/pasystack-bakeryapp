<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recipient_code', 32);
            $table->integer('amount')->nullable('false');
            $table->text('reason');
            $table->string('transfer_code', '32')->nullable();
            $table->integer('recipient_number')->nullable();
            $table->string('transfer_status', '32')->nullable();
            $table->datetime('next_payment')->nullable();
            $table->foreign('recipient_code')->references('recipient_code')->on('recipients');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
