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
        Schema::create('iva_rates', function (Blueprint $table) {
            $table->id();
            $table->float('value')->unsigned()->default(0.00);
            $table->string('descrip', 6);
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5);
            $table->string('title', 100);
            $table->string('subtitle', 200)->nullable();
            $table->string('descrip', 255)->nullable();
            $table->string('author', 50);
            $table->tinyInteger('edition')->unsigned()->default(1);
            $table->smallInteger('pub_year')->unsigned()->nullable(); // publication
            $table->string('isbn', 20)->nullable();
            $table->foreignId('collection_id')->nullable()->constrained();
            $table->foreignId('publisher_id')->constrained();
            $table->string('binding', 20)->nullable();
            $table->smallInteger('page_count')->unsigned()->nullable();
            $table->string('format', 20)->nullable();
            $table->tinyInteger('tome_count')->unsigned()->default(1);
            $table->smallInteger('weight')->unsigned()->nullable();
            $table->float('price')->unsigned()->default(0.00);
            $table->float('disc_rate')->unsigned()->default(0.00);
            $table->foreignId('iva_rate_id')->constrained();
            $table->string('status', 10)->default('Disponible'); // ['Disponible', 'Prestado', 'Reservado']
            $table->string('image', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('iva_rates');
    }
};
