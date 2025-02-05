<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name.*' => 'required',
            'file' =>'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:20240',
            'has_parent' => 'nullable',
            'parent_id' => 'required_with:has_parent|nullable|exists:categories,id',
        ];

        if ($this->isMethod('post')) {
            $rules['file'] = 'required|image|max:20240';
        }

        return $rules;
    }
}
