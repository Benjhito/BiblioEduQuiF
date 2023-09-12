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
        Schema::create('iva_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2);
            $table->string('descrip', 30);
            $table->timestamps();
        });

        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('business_name', 40);
            $table->string('address', 50)->nullable();
            $table->string('postcode', 8)->nullable();
            $table->string('locality', 40)->nullable();
            $table->string('province', 40)->nullable();
            $table->string('country', 40)->nullable();
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('acc_type', 2)->default('CC'); // ['CC', 'CA']
            $table->string('acc_number', 15)->nullable();
            $table->string('cuit', 13)->nullable();
            $table->foreignId('iva_type_id')->constrained();
            $table->string('inv_type', 1)->default('A'); // ['A', 'B', 'C', 'X']
            $table->string('contact', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
        Schema::dropIfExists('iva_types');
    }
};
