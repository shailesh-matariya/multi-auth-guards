<?php

namespace App\Guards;

use App\App3User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class App3Guard implements Guard
{
    protected $user;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function check()
    {
        return (bool)$this->user();
    }

    /**
     * @inheritDoc
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * @inheritDoc
     */
    public function user()
    {
        return $this->user ?: $this->getUserFromSession();
    }

    /**
     * @inheritDoc
     */
    public function id()
    {
        $user = $this->user();
        return $user->id ?? null;
    }

    /**
     * @inheritDoc
     */
    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
        // validation logic will go here
    }

    /**
     * @inheritDoc
     */
    public function setUser(?Authenticatable $user)
    {
        Session::put('app3_auth_user', $user);
        $this->user = $user;
        return $this;
    }

    protected function getUserFromSession()
    {
        return session('app3_auth_user');
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        $user = App3User::authenticateFromApi();

        $this->setUser($user);

        return true;
    }

    public function logout()
    {
        if ($this->user()) {
            $this->setUser(null);
        }
    }
}
