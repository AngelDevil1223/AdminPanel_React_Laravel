<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('seqnum');
            $table->string('comproperid');
            $table->string('pickuplatitude');
            $table->string('pickuplongitude');
            $table->string('dropofflatitude');
            $table->string('dropofflongitude');
            $table->string('pickuptimestamp');
            $table->string('dropofftimestamp');
            $table->string('rentalperiodmins');
            $table->string('customervehiclerating');
            $table->string('customerservicerating');
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
        Schema::dropIfExists('rentals');
    }
}
