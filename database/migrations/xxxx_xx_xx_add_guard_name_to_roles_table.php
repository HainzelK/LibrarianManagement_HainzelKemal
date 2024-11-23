<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'guard_name')) {
                $table->string('guard_name')->default('web');
            }
        });
        
        // Also update existing roles to have the guard_name
        DB::table('roles')->update(['guard_name' => 'web']);
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('guard_name');
        });
    }
}; 