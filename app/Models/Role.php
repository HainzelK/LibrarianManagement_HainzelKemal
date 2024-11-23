<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasRoles; // This trait provides convenient methods for managing roles

    // You can also define any custom properties or methods for your roles here
}
