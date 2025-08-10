<?php

namespace App\Shared\Support;

class ApiResponse
{
    public static function ok($data=null, string $message='ok'): array
    { return ['success'=>true,'message'=>$message,'data'=>$data]; }

    public static function error(string $message, ?array $errors=null): array
    { return ['success'=>false,'message'=>$message,'errors'=>$errors]; }
}
