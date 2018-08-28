<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class LotteriesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'prize_number' => 'required',
        ];
    }
}
