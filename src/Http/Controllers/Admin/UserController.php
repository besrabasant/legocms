<?php

namespace LegoCMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LegoCMS\Http\Requests\Admin\CreateUserRequest;
use LegoCMS\Models\Enums\UserRoles;

/**
 * Class UserController
 *
 * @category Controllers
 * @package  LegoCMS\Http\Controllers\Admin
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Http/Controllers/Admin/UserController.php
 */
class UserController extends ModuleController
{
    /**
     * $namespace
     *
     * @var string
     */
    protected $namespace = 'LegoCMS\\';

    /**
     * $moduleName.
     *
     * @var string
     */
    protected $moduleName = 'users';

    /**
     * {@inheritDoc}
     */
    protected function pageDefaults()
    {
        return [
            'page_titles' => [
                "index" => "Users",
                "edit" => "Edit User"
            ],
            'page_actions' => [
                'create' => 'Create User'
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function listingsDefaultColumns()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
        ];
    }

    /**
     * Prepares Data for Storage.
     *
     * @param  CreateUserRequest|Request $request
     *
     * @return array
     */
    protected function prepareDataForStore($request, $model = null)
    {
        return [
            'role' => $request->get('role', UserRoles::VISITOR),
            'published' => $request->get('published', true),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function prepareDataForUpdate($request, $model = null)
    {
        return [
            'published' => $request->get('published', true),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateViewAdditionalData()
    {
        return [
            'userRoles' => UserRoles::toArray()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getEditViewAdditionalData()
    {
        return [
            'userRoles' => UserRoles::toArray()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getIndexViewData()
    {
        $allUsers = $this->getModelName()::excludeSuperAdmin()->get();

        return [
            $this->getIndexViewDataKey() => $allUsers,
        ];
    }
}
