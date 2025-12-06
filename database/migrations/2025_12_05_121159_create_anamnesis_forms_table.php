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
        Schema::create('anamnesis_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->nullable()->constrained('pets');
            $table->foreignId('doctor_id')->nullable()->constrained('users');

            // INFORMACIÓN GENERAL
            $table->date('date')->nullable();

            // IDENTIFICACIÓN DEL PACIENTE
            $table->string('reproductive_status')->nullable();
            $table->decimal('weight', 10,2)->nullable();
            $table->string('identification')->nullable();

            // MOTIVO DE CONSULTA
            $table->text('main_problem')->nullable();
            $table->string('evolution_time')->nullable();
            $table->string('recent_changes')->nullable();

            // HISTORIA CLÍNICA ACTUAL
            $table->text('observed_signs')->nullable();
            $table->string('appetite')->nullable();
            $table->string('water_intake')->nullable();
            $table->string('activity')->nullable();
            $table->string('urination')->nullable();
            $table->string('defecation')->nullable();
            $table->string('temperature')->nullable();
            $table->string('heart_rate')->nullable();
            $table->string('respiratory_rate')->nullable();

            // HISTORIA CLÍNICA PREVIA
            $table->string('previous_diseases')->nullable();
            $table->string('previous_surgeries')->nullable();
            $table->string('current_medications')->nullable();
            $table->string('allergies')->nullable();
            $table->string('vaccines')->nullable();
            $table->string('deworming')->nullable();

            // ALIMENTACIÓN
            $table->string('diet_type')->nullable();
            $table->string('diet_brand')->nullable();
            $table->string('diet_frequency')->nullable();
            $table->string('diet_recent_changes')->nullable();

            // AMBIENTE Y MANEJO
            $table->string('housing')->nullable();
            $table->string('access_to_exterior')->nullable();
            $table->string('stay_place')->nullable();
            $table->text('cohabiting_animals')->nullable();
            $table->text('toxic_exposure')->nullable();

            // REPRODUCCIÓN
            $table->string('females_repro')->nullable();
            $table->string('males_repro')->nullable();
            $table->string('repro_complications')->nullable();

            // OBSERVACIONES ADICIONALES
            $table->text('additional_observations')->nullable();

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
        Schema::dropIfExists('anamnesis_forms');
    }
};
