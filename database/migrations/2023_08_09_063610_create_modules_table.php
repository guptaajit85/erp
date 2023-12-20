<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id(); 
           // $table->integer('user_id')->nullable();   
            $table->string('heading', 255)->nullable();
            $table->string('page_name', 255)->nullable();
             

            $table->dateTime('created')->nullable(); 
			$table->dateTime('modified')->nullable();			 
			$table->tinyInteger('status')->default(1);
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
