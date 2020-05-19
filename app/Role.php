<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Setup relationship between role and permissions
     *
     * @var array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
}
