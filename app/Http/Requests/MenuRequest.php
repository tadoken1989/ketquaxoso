<?php

namespace App\Http\Requests;

class MenuRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'content' => 'bail|required|max:450',
        ];
    }
}
