<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create-tag');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50|unique:tags,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên tag là bắt buộc.',
            'name.unique' => 'Tag này đã tồn tại.',
        ];
    }
}