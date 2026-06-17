<?php

namespace Modules\Management\WebsiteManagement\WhoWeAre\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DataStoreValidation extends FormRequest
{
    /**
     * Determine if the  is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * validateError to make this request.
     */
    public function validateError($data)
    {
        $errorPayload =  $data->getMessages();
        return response(['status' => 'validation_error', 'errors' => $errorPayload], 422);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validateError($validator->errors()));
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException($this->validateError($validator->errors()));
        }
        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'badge_label'          => 'nullable|string|max:100',
            'title'                => 'nullable|string|max:300',
            'description'          => 'nullable|string',
            'image'                => 'nullable',
            'sort_order'           => 'nullable|integer',
            'is_visible'           => 'nullable',
            'status'               => ['nullable', Rule::in(['active', 'inactive'])],
            'features'             => 'nullable|array',
            'features.*.icon'      => 'nullable|string',
            'features.*.title'     => 'nullable|string',
            'features.*.description' => 'nullable|string',
            'stats'                => 'nullable|array',
            'stats.*.stat_value'   => 'nullable|string',
            'stats.*.stat_label'   => 'nullable|string',
        ];
    }
}