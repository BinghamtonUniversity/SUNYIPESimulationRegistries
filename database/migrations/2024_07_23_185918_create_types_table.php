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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->index();
            $table->boolean('is_ipe')->default(false)->index();
            $table->boolean('is_simulation')->default(false)->index();
            $table->boolean('searchable')->default(true)->index();
            $table->boolean('multi_select')->default(false)->index();
            $table->unsignedInteger('order')->default(4294967295);
            $table->string('help_text')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
