<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;

class App3User extends Model implements \Illuminate\Contracts\Auth\Authenticatable {
    use Authenticatable;

    public static function authenticateFromApi()
    {
        // logic will go here to authenticate

        return new self([
            'id' => Str::random(8),
            'name' => Str::before(request()->email, '@'),
            'email' => request()->email
        ]);
    }
}
