<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToPracticesTable extends Migration
{
    /**
     * Veiciet migrāciju.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->string('type')->default('trenins'); // Pieviest 'type' kolonnu
        });
    }

    /**
     * Atgrieziet migrāciju.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
