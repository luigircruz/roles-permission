<?php

namespace App\Permissions;

use App\{Role, Permission};

trait HasPermissionsTrait
{
    /**
     * Setup relationship between user and its roles
     *
     * @var array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Setup relationship between user and its permissions
     *
     * @var array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_roles');
    }
}