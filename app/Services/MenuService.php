<?php

namespace App\Services;

use Exception;
use App\Models\Menu;
use App\Libraries\AppLibrary;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Libraries\QueryExceptionLibrary;
use Spatie\Permission\Models\Permission;

class MenuService
{
    /**
     * @throws Exception
     */
    public function menu(Role $role) : array
    {
        try {
            $menus           = Menu::get()->toArray();
            $permissions     = Permission::get();
            $rolePermissions = Permission::join(
                "role_has_permissions",
                "role_has_permissions.permission_id",
                "=",
                "permissions.id"
            )->where("role_has_permissions.role_id", $role->id)->get()->pluck('name', 'id');
            $permissions     = AppLibrary::permissionWithAccess($permissions, $rolePermissions);
            $permissions     = AppLibrary::pluck($permissions, 'obj', 'url');
            return AppLibrary::numericToAssociativeArrayBuilder(AppLibrary::menu($menus, $permissions));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }
}
