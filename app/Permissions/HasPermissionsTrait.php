<?php

namespace App\Permissions;

use App\{Role, Permission};

trait HasPermissionsTrait
{
    /**
     * Check if the user has a specified role
     *
     * @return bool
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
     * Check if the user has a permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    /**
     * Check if a permission record exists within a user
     *
     * @return bool
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    /**
     * Setup relationship between user and its roles
     *
     * @return array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Setup relationship between user and its permissions
     *
     * @return array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
}