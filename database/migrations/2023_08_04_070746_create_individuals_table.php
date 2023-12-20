<?php

use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individuals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->enum('type', ['customers', 'master', 'agents', 'labourer', 'vendors'])->default('customers');
            $table->string('phone', 10)->nullable();            
            $table->string('company_name', 100)->nullable();
            $table->string('nick_name', 100)->nullable();
            $table->string('gstin', 100)->nullable();
            $table->string('pan', 100)->nullable();            
            $table->string('tanno', 100)->nullable();
            $table->string('adhar', 100)->nullable();
            $table->string('whatsapp', 100)->nullable();
            $table->string('email', 100)->nullable();            
            $table->string('verified_remark', 100)->nullable();
            $table->enum('is_verified', ['yes', 'no'])->default('no');    
            
            $table->dateTime('created')->nullable(); 
			$table->dateTime('modified')->nullable();  
 
 
            $table->tinyInteger('status')->default(1);

			  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individuals');
    }
}
