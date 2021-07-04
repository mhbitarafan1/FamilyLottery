<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfile extends FormRequest
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
        
        return [
            'name'=>'string|max:50|required',
            'phone_number'=>['string','digits:11','required',Rule::unique('users','phone_number')->ignore(auth()->user()->id)],
            'avatar'=>'max:1000|mimes:jpg,jpeg,png,gif',            
        ];
    }
}
