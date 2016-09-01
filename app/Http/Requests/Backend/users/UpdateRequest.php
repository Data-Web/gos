<?php

namespace App\Http\Requests\Backend\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'required|alpha_dash|min:3|max:50|unique:users,username,' . $this->id,
            'fullname' => 'required|min:2|max:50',
            'phone' => 'numeric',
            'gender' => 'required',
            'email' => 'required|email|max:255|unique:users,email,' . $this->id,
            'birthday' => 'date_format:d/m/Y|before:tomorrow',
        ];
        
        return $rules;
    }

    public function response(array $errors)
    {
        return response()->json([
            'errors' => true,
            'messages'  => $errors,
        ], 422);
    }

    public function messages()
    {
        return [
            'username.required' => 'Tài khoản không được bỏ trống',
            'username.alpha_dash' => 'Tài khoản không được chứa kí tự đặc biệt',
            'username.min' => 'Tài khoản phải từ 2 ký tự trở lên',
            'username.max' => 'Tài khoản không vượt quá 50 kí tự',
            
            'fullname.required' => 'Họ và tên không được bỏ trống',
            'fullname.min' => 'Họ và tên phải từ 2 ký tự trở lên',
            'fullname.max' => 'Họ và tên không vượt quá 50 kí tự',

            'phone.numeric' => 'Điện thoại phải là định dạng số',
            
            'gender.required' => 'Vui lòng chọn giới tính',

            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            
            'birthday.date_format' => 'Ngày sinh không đúng định dạng',
            'birthday.before' => 'Ngày sinh không được lớn hơn ngày hiện tại',
        ];
    }
}