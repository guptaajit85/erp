<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
 
class CreateCotingsTable extends Migration
{
 
 
 
 
 
    public function up()
 
        {

 
            Schema::create('cotings', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->nullable();
                $table->dateTime('created')->nullable();
                $table->dateTime('modified')->nullable();
                $table->tinyInteger('status')->default(1);
            });
        }
    public function down()
    {
        Schema::dropIfExists('cotings');
 
       
    }
 
 
}
