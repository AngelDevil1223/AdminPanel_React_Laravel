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
            $table->string('ownerIdNum');
            $table->string('ownerbirthhij');
            $table->string('ownerbirthgre');
            $table->string('seqnum');
            $table->string('rplateletter');
            $table->string('mplateletter');
            $table->string('lplateletter');
            $table->string('platenum');
            $table->string('platetype');
            $table->string('currentlessor');
            $table->string('status');
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
        Schema::dropIfExists('vehicles');
    }
}
