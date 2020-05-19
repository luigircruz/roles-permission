<?php

namespace App\Permissions;

use App\{Role, Permission};

trait HasPermissionsTrait
{
    /**
     * Check if the user has a specified role
     *
     * @var bool
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role)
        {
            if ($this->roles->contains('name', strtolower($role)))
            {
                return true;
            }
        }

        return false;
    }

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