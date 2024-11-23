<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DisableForeignKeyChecksAndDropRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // Drop the roles table if it exists
        Schema::dropIfExists('roles');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // You can recreate the roles table here if necessary, or handle rollback logic
        // For example:
        // Schema::create('roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->timestamps();
        // });
    }
}
