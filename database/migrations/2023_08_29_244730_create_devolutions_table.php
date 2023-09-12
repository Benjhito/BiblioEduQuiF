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
        Schema::create('devolutions', function (Blueprint $table) {
            $table->id();
            $table->date('dev_date');
            $table->integer('dev_number')->unsigned();
            $table->foreignId('member_id')->constrained();
            $table->string('status', 10)->default('Pendiente'); // ['Pendiente', 'Confirmada']
            //$table->string('notes', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolutions');
    }
};
