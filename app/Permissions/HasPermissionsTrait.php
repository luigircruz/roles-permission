<?php

namespace App\Permissions;

use App\Permission;
use App\Role;
use Illuminate\Support\Arr;

trait HasPermissionsTrait
{
    /**
     * Give a permission to a user.
     *
     * @return array
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(Arr::flatten($permissions));

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * Revoke a permission to a user.
     *
     * @return array
     */
    public function revokePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(Arr::flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * Update user permissions.
     *
     * @return array
     */
    public function updatePermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * Check if the user has a specified role.
     *
     * @return bool
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', strtolower($role))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has a permission.
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Check if a permission record exists within a user.
     *
     * @return bool
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    /**
     * Check if the user has a permission through a role he is assigned.
     *
     * @return bool
     */
    protected function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all permissions from storage.
     *
     * @return bool
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * Setup relationship between user and its roles.
     *
     * @return array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Setup relationship between user and its permissions.
     *
     * @return array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
}
