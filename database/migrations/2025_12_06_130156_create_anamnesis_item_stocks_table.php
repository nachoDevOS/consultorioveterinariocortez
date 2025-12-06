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
        Schema::create('anamnesis_item_stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anamnesisForm_id')->nullable()->constrained('anamnesis_forms');
            $table->foreignId('itemStock_id')->nullable()->constrained('item_stocks');

            $table->decimal('pricePurchase', 10, 2)->nullable(); // precio de compra del item

            $table->decimal('price', 10, 2)->nullable(); // precio unitario de venta
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();

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
        Schema::dropIfExists('anamnesis_item_stocks');
    }
};
