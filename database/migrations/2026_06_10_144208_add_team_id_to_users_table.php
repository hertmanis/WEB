<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a nullable team_id column to reference teams. It is nullable in case a user is not assigned to a team.
            $table->unsignedBigInteger('team_id')->nullable()->after('id');

            // Define foreign key constraint.
            $table->foreign('team_id')
                  ->references('id')->on('teams')
                  ->onDelete('cascade');  // When a team is deleted, its users can be deleted or set to null (adjust as needed)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }
};
