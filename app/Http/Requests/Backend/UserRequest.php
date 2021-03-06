<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $all = $this->all();
        if (!isset($all['password']) || empty($all['password'])) {
            unset($all['password']);
        }
        $this->replace($all);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PATCH')
        {
            return [
                'fullname' => 'required|min:2|max:40',
                'username' => "required|alpha_dash|min:4|max:40|unique:users,username," . $this->user,
                'email' => "required|email|max:255|unique:users,email," . $this->user,
                'password' => 'confirmed|alpha_dash|min:6',
                'password_confirmation' => 'min:6',
                'gender' => 'required',
                'branch_id' => 'required|not_in:0',
                'birthday' => 'date_format:d/m/Y|before:tomorrow',
                'image'=> 'image|mimes:jpeg,jpg,gif,bmp,png|max:1200',
            ];
        } else {
            return [
                'fullname' => 'required|min:2|max:40',
                'username' => "required|alpha_dash|min:4|max:40|unique:users",
                'email' => "required|email|max:255|unique:users",
                'password' => 'required|alpha_dash|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
                'birthday' => 'date_format:d/m/Y|before:tomorrow',
                'gender' => 'required',
                'branch_id' => 'required|not_in:0',
                'image'=> 'image|mimes:jpeg,jpg,gif,bmp,png|max:1200',
            ];
        }
    }
}
