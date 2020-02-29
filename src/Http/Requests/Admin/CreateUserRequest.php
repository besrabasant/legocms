<?php

namespace LegoCMS\Http\Requests\Admin;

/**
 * Class CreateUserRequest
 *
 * @package LegoCMS\Http\Requests\Admin
 */
class CreateUserRequest extends FormRequest
{
    public function applyRules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:LegoCMS\Models\User,email',
            'role' => 'required|not_in:SUPERADMIN'
        ];
    }
}
