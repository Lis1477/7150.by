<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('link');
            $table->string('title')->nullable();
            $table->string('categories')->nullable()->comment('Коды категорий через точку с запятой');
            $table->integer('active')->default(1)->comment('1-активен, 0-скрыт');
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
        Schema::dropIfExists('category_banners');
    }
}
