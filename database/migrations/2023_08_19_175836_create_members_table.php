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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code', 4)->nullable(); //->unique();
            $table->string('last_name', 30);
            $table->string('first_name', 30);
            $table->string('doc_number', 13)->nullable();
            //$table->string('card_number', 13)->nullable();
            $table->string('address', 50)->nullable();
            $table->string('postcode', 8)->nullable();
            $table->string('locality', 40)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->date('adm_date')->nullable(); // admission date
            $table->string('status', 10)->default('Activo'); // ['Activo', 'Suspendido']
            $table->string('notes', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
