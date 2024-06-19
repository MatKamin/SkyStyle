<?php

namespace App\Session;

use Illuminate\Support\Str;
use Illuminate\Session\DatabaseSessionHandler;

class CustomDatabaseSessionHandler extends DatabaseSessionHandler
{
    /**
     * Create a new session ID.
     *
     * @return string
     */
    public function createSessionId()
    {
        return (string) Str::uuid();
    }
}
