<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_loads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('amount', 45);
            $table->timestamps();
            $table->integer('products_id')->index('fk_details_loads_products1_idx');
            $table->integer('loads_id')->index('fk_details_loads_loads1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details_loads');
    }
};