<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_id')->nullable();
            $table->string('account_number',15);
            $table->string('account_name', 100);
            $table->string('ifsc_code', 100);  
            $table->string('bank_branch', 100);
            $table->string('bank_address', 100);
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
        Schema::dropIfExists('bank_accounts');
    }
}
