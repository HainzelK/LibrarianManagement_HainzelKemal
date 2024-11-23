<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{


public function up()
{
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Reference to the user (student)
        $table->foreignId('inventory_id')->constrained()->onDelete('cascade');  // Reference to the inventory (book/CD/DVD)
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Reservation status
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('reservations');
}

}
