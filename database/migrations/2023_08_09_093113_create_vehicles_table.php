<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {

			$table->id();
			$table->enum('lorry_type', ['I','L','B'])->default('I');
			$table->enum('lorry_owner', ['C','H'])->default('H');
			$table->string('vehicle_type', 55)->nullable();
			$table->string('body_type', 55)->default('Open');
			$table->string('lorry_number', 55)->nullable();
            $table->integer('brand_id')->default(0);
            $table->integer('gvw')->default(0);
            $table->integer('chasis_weight')->default(0);
            $table->integer('lorryowner_id')->default(0);
            $table->string('owner_name', 55)->default(0);
            $table->string('owner_address', 255)->default(0);
            $table->string('owner_phone', 55)->default(0);
            $table->string('pan_number', 55)->default(0);
            $table->string('engine_no', 55)->default(0);
            $table->string('chassis_no', 55)->default(0);
            $table->string('modeltype', 55)->default(0);
            $table->string('tds_declare', 55)->default(0);
            $table->string('npno', 255)->default(0);
            $table->string('policy_no', 255)->default();
            $table->date('policy_date')->nullable(0);
            $table->date('valid_date')->nullable(0);
            $table->string('colour', 255)->default(0);
            $table->integer('created_by')->default(1);
            $table->integer('modified_by')->default(1);


			$table->dateTime('created')->nullable();
			$table->dateTime('modified')->nullable();
			$table->tinyInteger('status')->default(1);


			/*

			`vehicle_capacity` int(11) NOT NULL,
			`fuelcard_id` int(11) NOT NULL,
			`fasttag_id` int(11) NOT NULL,
			`to_fuelcard_ledger` int(11) NOT NULL,
			`to_fastag_ledger` int(11) NOT NULL,
			`from_fastag_ledger` int(11) NOT NULL,
			`from_fuelcard_ledger` int(11) NOT NULL,
			`from_trip_ledger` int(11) NOT NULL,
			`from_insurance_ledger` int(11) NOT NULL,
			`from_legal_ledger` int(11) NOT NULL,
			`from_rto_ledger` int(11) NOT NULL,
			`from_misc_ledger` int(11) NOT NULL,
			`from_food_ledger` int(11) NOT NULL,
			`from_unload_ledger` int(11) NOT NULL,
			`from_electrical_ledger` int(11) NOT NULL

			*/


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
        Schema::dropIfExists('vehicles');
    }
}
