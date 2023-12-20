<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->integer('individual_id')->default(0);
            $table->string('name', 255)->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->date('dob', 0)->nullable();
            $table->date('doa', 0)->nullable();
            $table->string('image', 255)->nullable();
			$table->text('fb_link')->nullable();
			$table->string('call_no', 10)->nullable();
			$table->string('whatsapp', 10)->nullable();
			 
			$table->tinyInteger('is_po_genrated')->default(0);
			$table->tinyInteger('is_work_order_genrated')->default(0);
			$table->tinyInteger('is_warp_process')->default(0);
			$table->tinyInteger('is_drawing_process')->default(0);
			$table->tinyInteger('is_weave_process')->default(0);
			$table->tinyInteger('is_dyeing_process')->default(0);
			$table->tinyInteger('is_coting_process')->default(0);
			$table->tinyInteger('is_work_order_completed')->default(0);
			$table->tinyInteger('is_invoice_generated')->default(0);
			$table->tinyInteger('is_packing')->default(0);
			$table->tinyInteger('is_dispatch')->default(0);
			$table->tinyInteger('created_by')->nullable();
			$table->tinyInteger('modified_by')->nullable(); 
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
        Schema::dropIfExists('people');
    }
}
