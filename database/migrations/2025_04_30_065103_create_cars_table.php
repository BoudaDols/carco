<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year');
            $table->integer('price');
            $table->string('description');
            $table->string('color');
            $table->string('chassisNumber');
            $table->unsignedBigInteger('categorie_id');
            $table->unsignedBigInteger('brand_id');
            $table->timestamps();

            //Declaration de clés etrangères avec Categorie
            $table->foreign('categorie_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');

            //Declaration de clés etrangères avec Model
            $table->foreign('brand_id')
                    ->references('id')
                    ->on('brands')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
