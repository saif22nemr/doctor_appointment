<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->boolean('view')->default(1)->after('name');
            $table->boolean('create')->default(1)->after('view');
            $table->boolean('edit')->default(1)->after('create');
            $table->boolean('delete')->default(1)->after('edit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->dropColumn('view');
            $table->dropColumn('create');
            $table->dropColumn('edit');
            $table->dropColumn('delete');
        });
    }
}
