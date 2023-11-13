<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\models\User ;
class NotificationRequest extends FormRequest
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
    public function rules(): array
    {
            return [
                'notification_type' => 'required|integer',
                'note' => 'nullable|string|max:150',
                'users.*' => 'required',
            ];
    }

    public function getData()
    {
        $data = [];
        if( $this->users[0] =='all'  ){
            $data['users'] =  User::get()->pluck('id')->toArray();
        }
        return $data  +  parent::validated() ;
    }
}
