<?php

namespace App\Http\Requests\Discussions;

use App\Enums\DiscussionStatus;
use App\Enums\DiscussionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscussionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'type'   => ['required', Rule::in(DiscussionType::cases())],
            'status' => ['required', Rule::in(DiscussionStatus::cases())],
            'title'  => ['required', 'min:3', 'max:255'],
        ];
    }
}
