<?php

namespace App\Modules\Ticketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRegistrationRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'event_id'       => ['required','integer','exists:events,id'],
            'ticket_type_id' => ['required','integer','exists:ticket_types,id'],
            'user_id'        => ['nullable','integer','exists:users,id'],
            'buyer_email'    => ['required','email'],
        ];
    }
    public function tenantId(): int { return (int) app('tenant_id'); }
}
