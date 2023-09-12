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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->date('rec_date');
            $table->foreignId('book_id')->constrained();
            $table->string('book_code', 5);
            $table->string('title', 100);
            $table->string('isbn', 20)->nullable();
            $table->foreignId('provider_id')->constrained();
            $table->integer('quantity')->unsigned();
            $table->integer('missing')->unsigned()->nullable();
            $table->integer('surplus')->unsigned()->nullable();
            $table->float('price')->unsigned()->default(0.00);
            $table->float('disc_rate')->unsigned()->default(0.00);
            $table->foreignId('iva_rate_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
