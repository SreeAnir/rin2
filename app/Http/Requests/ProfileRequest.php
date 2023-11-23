<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\models\User ;
class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $phoneChanged = request()->phone_number != auth()->user()->phone_number;
        $rules = [
            'phone_number' => 'required',
            'otp_validated' => 'required_if:phone_changed,true',
        ];
        return match ($this->getMethod()) {
            'POST' => [
                    'email' => 'required|email|unique:users,email',
                ] + $rules,
            'PUT', 'PATCH' => [
                    'email' => 'required|email|unique:users,email,'.$this->user_id,
                ] + $rules,
            default => []
        };
    }

    public function getData()
    {
        $data = [];
        $data['email'] =  $this->email;
        $data['notification_switch'] =  ($this->notification_switch  && $this->notification_switch == 'on' ? 1 : 0);
        $data['phone_number'] =  $this->phone_number;
        return $data  ;
    }
}
