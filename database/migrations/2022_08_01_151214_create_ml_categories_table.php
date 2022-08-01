<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMLCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_categories', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->string('picture')->nullable();
            $table->string('permalink')->nullable();
            $table->string('total_items_in_this_category')->nullable();
            $table->json('path_from_root')->nullable();
            $table->json('children_categories')->nullable();
            $table->string('date_created')->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ml_categories');
    }
}
