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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submitter_id');
            $table->boolean('is_ipe')->default(false)->index();
            $table->boolean('is_simulation')->default(false)->index();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('ksa_requirement')->nullable();
            $table->string('learning_objectives')->nullable();
            $table->unsignedInteger('number_of_learners')->nullable();
            $table->enum('status',['submitted','review','approved'])->default('submitted')->index();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('approved_at')->nullable();
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};