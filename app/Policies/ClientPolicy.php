<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ClientPolicy
{
    public function update(User $user, Client $client){
        return $user->isAdmin();
    }
    public function delete(User $user, Client $client){
        return $user->isAdmin();
    }
}
