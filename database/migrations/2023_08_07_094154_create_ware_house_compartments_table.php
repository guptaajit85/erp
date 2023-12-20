<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWareHouseCompartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ware_house_compartments', function (Blueprint $table) {
            $table->id();
            $table->string('warehousename', 255)->nullable();
            $table->integer('warehouseid'); 
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
        Schema::dropIfExists('ware_house_compartments');
    }
}
