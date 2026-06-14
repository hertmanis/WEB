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
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade'); // Ja izdzēš komandu, automātiski izdzēšas arī visi piesaistītie treniņi
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade'); // Ja izdzēš treneri, automātiski izdzēšas arī visi viņa treniņi
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('scheduled_at');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('practices');
    }
};
