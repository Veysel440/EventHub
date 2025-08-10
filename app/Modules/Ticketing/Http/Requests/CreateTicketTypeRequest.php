<?php

namespace App\Modules\Ticketing\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateTicketTypeRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('tickets.manage'); }
    public function rules(): array {
        return [
            'event_id' => ['required','integer','exists:events,id'],
            'name'     => ['required','string','max:120'],
            'stock'    => ['required','integer','min:0'],
            'price'    => ['required','numeric','min:0'],
            'currency' => ['nullable','string','size:3'],
        ];
    }
    public function tenantId(): int { return (int) app('tenant_id'); }
}
