<?php

namespace LaraDev\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Contract extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rent' => 'different:sale',
            'owner' => 'required',
            'acquirer' => 'required|different:owner',
            'sale_price' => 'required_if:sale,on',
            'rent_price' => 'required_if:rent,on',
            'property' => 'required|integer',
            'due_date' => 'required|integer|min:1|max:28',
            'deadline' => 'required|integer|min:12|max:48',
            'start_at' => 'required',
        ];
    }
}
