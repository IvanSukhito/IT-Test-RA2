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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ewallet_sender_id')->default(0);
            $table->unsignedBigInteger('ewallet_receiver_id')->nullable();
            $table->string('trx_code');
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('direction',['in','out']);
            $table->enum('status',['success','pending','failed']);
            $table->foreign('ewallet_sender_id')->references('id')->on('ewallets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
