<?php

namespace Modules\Management\ProductManagement\Product\Validations;

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
            'product_group_id'       => 'sometimes|nullable',
            'name'                   => 'sometimes|nullable|string|max:255',
            'slug'                   => 'sometimes|nullable|string|max:255',
            'description'            => 'sometimes|nullable|string',
            'status'                 => ['sometimes', 'nullable', Rule::in(['active', 'planning', 'development', 'paused'])],
            'launch_date'            => 'sometimes|nullable|date',
            'monthly_target_revenue' => 'sometimes|nullable|numeric|min:0',
            'features'               => 'sometimes|nullable',
            'screenshots'            => 'sometimes|nullable',
            'regular_price'          => 'sometimes|nullable|numeric|min:0',
            'sales_price'            => 'sometimes|nullable|numeric|min:0',
            'thumbnail'              => 'sometimes|nullable|image|max:2048',
            'promo_link'             => 'sometimes|nullable|url|max:500',
        ];
    }
}