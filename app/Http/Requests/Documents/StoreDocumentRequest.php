<?php

namespace App\Http\Requests\Documents;

use App\Enums\DocumentType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreDocumentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'upload' => ['file', 'image', 'max:16000', 'dimensions:min_width=100,min_height=200'],
            'user_id' => ['integer', 'exists:users,id'],
            'type' => ['required', Rule::in(DocumentType::cases())],
        ];
    }
//    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
//    {
//        throw new HttpResponseException(response()->json($validator->errors(), 422));
//    }
}
