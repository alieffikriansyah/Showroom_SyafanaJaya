<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSistemTables extends Migration
{
    public function up()
    {
        // Tabel 1: menu_sistem
        Schema::create('menu_sistem', function (Blueprint $table) {
            $table->increments('id_menu');
            $table->string('nama_menu', 100);
            $table->string('route_name', 100);
            $table->string('icon', 100)->default('typcn typcn-document');
            $table->unsignedInteger('parent_id')->nullable();
            $table->integer('urutan')->default(0);
            $table->tinyInteger('is_active')->default(1);
        });

        // Tabel 2: jabatan_menu (pivot)
        Schema::create('jabatan_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('jabatan_id_jabatan');
            $table->unsignedInteger('menu_id_menu');

            $table->foreign('menu_id_menu')
                  ->references('id_menu')
                  ->on('menu_sistem')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jabatan_menu');
        Schema::dropIfExists('menu_sistem');
    }
}

