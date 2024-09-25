<?php

namespace App\Services;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\URL;

class CustomPasswordBroker extends PasswordBroker
{
    protected function sendResetLinkResponse($response)
    {
        return response(['status' => trans($response)]);
    }

    protected function getResetUrl($token)
    {
        return url('admin/password/reset', $token) . '?email=' . urlencode(request()->email);
    }
}
