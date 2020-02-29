<?php

namespace LegoCMS\Http\Requests\Admin;

/**
 * Class UpdateUserRequest
 *
 * @package LegoCMS\Http\Requests\Admin
 */
class UpdateUserRequest extends FormRequest
{
    public function applyRules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:LegoCMS\Models\User,email,' . $this->route('user'),
            'role' => 'required'
        ];
    }
}
