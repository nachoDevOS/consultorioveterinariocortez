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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();    
            $table->foreignId('service_id')->nullable()->constrained('services');
            $table->foreignId('animal_id')->nullable()->constrained('animals');

            $table->string('nameClient')->nullable();
            $table->string('phoneClient')->nullable(); 
            
            $table->string('nameAnimal')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();

            $table->date('date')->nullable();
            $table->time('time')->nullable();

            $table->string('file')->nullable();

            $table->text('observation')->nullable(); //detalle de la observacion

            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();


            $table->smallInteger('view')->default(0);
            $table->string('status')->default('Pendiente');

            $table->timestamps();            
            $table->foreignId('registerUser_id')->nullable()->constrained('users');
            $table->string('registerRole')->nullable();

            $table->softDeletes();
            $table->foreignId('deleteUser_id')->nullable()->constrained('users');
            $table->string('deleteRole')->nullable();
            $table->text('deleteObservation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
