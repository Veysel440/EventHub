<?php

namespace App\Modules\Ticketing\Http\Requests;

use App\Shared\Http\ApiFormRequest;

class CheckInRequest extends ApiFormRequest
{
    public function authorize(): bool { return $this->user()?->can('checkin.manage') ?? false; }
    public function rules(): array {
        return [
            'qr_code' => ['required','uuid'],
        ];
    }
    public function tenantId(): int { return (int) app('tenant_id'); }
}
