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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->nullable()->constrained('people');
            $table->foreignId('animal_id')->nullable()->constrained('animals');  

            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();


            
            $table->decimal('pricePurchase', 10, 2)->nullable();
            $table->decimal('priceSale', 10, 2)->nullable();

            $table->string('type')->nullable(); //Ingreso, Egreso            
            $table->text('observation')->nullable();

            $table->smallInteger('status')->default(1);

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
        Schema::dropIfExists('pets');
    }
};
