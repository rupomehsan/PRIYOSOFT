<?php

namespace Modules\Management\TodoManagement\TodoList\Validations;

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
            'todo_group_id' => 'required | sometimes',
            'title' => 'required | sometimes',
            'assigned_to' => 'required | sometimes',
            'estimated_days' => 'required | sometimes',
            'daily_rate' => 'required | sometimes',
            'fixed_cost' => 'required | sometimes',
            'item_cost' => 'required | sometimes',
            'is_recurring' => 'required | sometimes',
            'priority' => 'required | sometimes',
            'status' => 'required | sometimes',
            'completed_at' => 'required | sometimes',
            'note' => 'required | sometimes',
            'sort_order' => 'required | sometimes',
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ];
    }
}