<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_items', function (Blueprint $table) {
            $table->id();
			$table->string('name', 255)->nullable();
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
        Schema::dropIfExists('process_items');
    }
}
