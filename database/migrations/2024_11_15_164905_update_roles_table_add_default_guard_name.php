<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRolesTableAddDefaultGuardName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Set a default value for 'guard_name'
            $table->string('guard_name')->default('web')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Optionally remove the default value
            $table->string('guard_name')->default(null)->change();
        });
    }
}
