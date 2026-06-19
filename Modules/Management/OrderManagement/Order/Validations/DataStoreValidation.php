<?php

namespace Modules\Management\OrderManagement\Order\Validations;

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
            // order identifiers
            'order_number'            => 'sometimes|nullable|string',
            'product_id'              => 'sometimes|nullable|integer',
            'customer_id'             => 'sometimes|nullable|integer',
            'billing_cycle'           => 'sometimes|nullable|string',
            'coupon_code'             => 'sometimes|nullable|string',
            'ordered_at'              => 'sometimes|nullable',
            'payment_verified_at'     => 'sometimes|nullable',
            'access_sent_at'          => 'sometimes|nullable',
            'cancelled_at'            => 'sometimes|nullable',
            'created_by'              => 'sometimes|nullable',
            'status'                  => ['sometimes', 'nullable', Rule::in(['active', 'inactive'])],

            // customer
            'customer_name'           => 'sometimes|nullable|string|max:200',
            'customer_phone'          => 'sometimes|nullable|string|max:30',
            'customer_email'          => 'sometimes|nullable|email|max:200',
            'domain_name'             => 'sometimes|nullable|string|max:255',
            'preferred_delivery_date' => 'sometimes|nullable|date',

            // product / plan
            'product_name'            => 'sometimes|nullable|string|max:255',
            'plan_name'               => 'sometimes|nullable|string|max:200',

            // pricing
            'subtotal'                => 'sometimes|nullable|numeric|min:0',
            'discount_amount'         => 'sometimes|nullable|numeric|min:0',
            'total_amount'            => 'sometimes|nullable|numeric|min:0',

            // payment
            'payment_method'          => 'sometimes|nullable|string',
            'pay_now'                 => 'sometimes|nullable|boolean',
            'order_status'            => 'sometimes|nullable|string',
            'delivery_method'         => 'sometimes|nullable|string',

            // text
            'project_description'     => 'sometimes|nullable|string',
            'special_requirements'    => 'sometimes|nullable|string',
            'customer_note'           => 'sometimes|nullable|string',
            'admin_note'              => 'sometimes|nullable|string',
        ];
    }
}