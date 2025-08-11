<?php

namespace App\Modules\Ticketing\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ticketing\Application\Services\VerifyTicketService;
use App\Modules\Ticketing\Application\Services\CheckInService;
use App\Modules\Ticketing\Http\Requests\CheckInRequest;
use App\Modules\Ticketing\Http\Resources\RegistrationResource;
use App\Shared\Support\ApiResponse;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function verify(Request $r, VerifyTicketService $svc)
    {
        $r->validate(['qr_code'=>['required','uuid']]);
        $reg = $svc->handle($r->string('qr_code'));
        return response()->json(ApiResponse::ok(new RegistrationResource($reg->load(['ticketType','event']))));
    }

    public function checkin(CheckInRequest $r, CheckInService $svc)
    {
        $reg = $svc->handle($r->string('qr_code'));
        return response()->json(ApiResponse::ok(new RegistrationResource($reg)));
    }
}
