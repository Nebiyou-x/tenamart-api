<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('waiting_lists', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('signup_source');
        $table->timestamps(); // includes created_at
    });
}

    /**
     * Reverse the migrations.
     * 
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waiting_lists');
    }
}
