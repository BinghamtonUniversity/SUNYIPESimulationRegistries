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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id')->index();
            $table->unsignedBigInteger('user_id_created')->index()->nullable()->default(null);
            $table->unsignedBigInteger('user_id_deleted')->index()->nullable()->default(null);
            $table->json('data');
            $table->foreign('user_id_created')->references('id')->on('users');
            $table->foreign('user_id_deleted')->references('id')->on('users');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
