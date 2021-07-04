<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLottery extends FormRequest
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
            'name' => 'required|max:255',
            'amount' => 'required|max:15',
            'day' => 'required|digits_between:1,31',
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|numeric|min:1399|max:1500',
            'cycle' => 'required|string|max:30',
            'count_of_lots' => 'required|integer|max:100',
            'type_of_income' => 'required|string|max:30',
            'type_of_choose_winner' => 'required|string|max:30',
            'short_description' => 'string|max:255|nullable',            
            'hour' => 'numeric|min:0|max:24',            
        ];
    }
}
