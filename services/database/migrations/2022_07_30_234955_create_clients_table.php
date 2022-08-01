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
        Schema::create('clients', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->text('name');
            $table->text('birthday');
            $table->text('rg');
            $table->text('cpf')->unique();
            $table->text('cep');
            $table->text('street');
            $table->integer('number')->unsigned();
            $table->text('neighborhood');
            $table->text('city');
            $table->text('state');
            $table->longText('photo');
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
        Schema::dropIfExists('clients');
    }
};
