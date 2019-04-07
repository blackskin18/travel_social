<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['lat.*'              => 'required',
                'lng.*'              => 'required',
                'marker_description.*' => 'string|nullable',
                'photos.*'           => 'image',
                'post_description'   => 'string|nullable'];
    }
}
