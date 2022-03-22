<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatelocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updatelocations', function (Blueprint $table) {
            $table->id();
            $table->string("vehicleseqnum");
            $table->string("latitude");
            $table->string("longitude");
            $table->string("updatewhen");
            $table->string("hascustomer");
            $table->string("cuslocation");
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
        Schema::dropIfExists('updatelocations');
    }
}
