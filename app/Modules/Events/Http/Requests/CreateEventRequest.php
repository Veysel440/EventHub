<?php

namespace App\Modules\Events\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('events.create'); }
    public function rules(): array {
        return [
            'venue_id'   => ['nullable','integer','exists:venues,id'],
            'title'      => ['required','string','max:255'],
            'description'=> ['nullable','string'],
            'starts_at'  => ['required','date'],
            'ends_at'    => ['required','date','after:starts_at'],
        ];
    }
    public function tenantId(): int { return (int) app('tenant_id'); }
}
