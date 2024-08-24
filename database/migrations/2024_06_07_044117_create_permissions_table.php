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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('permission',[
                "view_users", //view list of all users
                "manage_users", //view, create, update, or delete any user
                "manage_permissions", //create or update all users' permissions
                "view_activities",
                "manage_activities", // create or update all activities
                "manage_site_configurations", // create or update all site configurations
                "view_types",
                "manage_types", //create update types
                "manage_campuses",
                "view_reports", // view all the reports created
                "manage_reports", // manage the reports and their queries
                "run_reports" // run the existing reports
            ]);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
