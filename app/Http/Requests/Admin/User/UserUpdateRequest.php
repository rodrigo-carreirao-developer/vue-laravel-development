<?php

namespace App\Http\Requests\Admin\User;

use App\Base\BaseRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends BaseRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }
}
