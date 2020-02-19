<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteStructureTable extends Migration
{
    public function up()
    {
        Schema::create('site_structure', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('reference')->unique();
        });
    }

    public function down()
    {
    }
}
