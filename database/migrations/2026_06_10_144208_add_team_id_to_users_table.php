<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Papildina tabulu ar jaunām kolonnām (php artisan migrate)
     */
    public function up()
    {
        
        Schema::table('users', function (Blueprint $table) {
            // Pieliek jaunu kolonnu team_id uzreiz aiz lietotāja

            $table->unsignedBigInteger('team_id')->nullable()->after('id');

            // Nodefinē ārējo atslēgu , kas saista šo kolonnu ar 'teams' tabulas 'id' kolonnu
            $table->foreign('team_id')
                  ->references('id')->on('teams')
                  ->onDelete('cascade');  // Ja izdzēš komandu, automātiski izdzēšas arī visi piesaistītie lietotāji
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }
};