<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_types', function (Blueprint $table) {
            $table->id();
            $table->string('qualitytype_name', 100);

            $table->dateTime('created')->nullable();
			$table->dateTime('modified')->nullable();

			$table->tinyInteger('status')->default(1);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_types');
    }
}
