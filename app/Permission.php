<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Setup relationship between role and premission
     *
     * @var array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
