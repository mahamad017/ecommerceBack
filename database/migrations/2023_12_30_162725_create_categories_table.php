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
        // create categories table
    if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('desc');
                $table->string('image');
                $table->timestamps();
            });
        }
        // add category key to products table
        Schema::table('products', function ($table) {
            if (!Schema::hasColumn('products', 'category')) {
                $table->integer('category');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the categories table only if it exists
        if (Schema::hasTable('categories')) {
            Schema::dropIfExists('categories');
        }

        // Drop the category key column only if it exists
        Schema::table('products', function ($table) {
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
