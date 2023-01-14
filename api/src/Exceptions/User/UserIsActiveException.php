<?php

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserIsActiveException extends ConflictHttpException
{

    private const MESSAGE = 'User %s is alredy active';

    public static function fromEmail(string $email)
    {
        throw new self(sprintf(self::MESSAGE, $email));
    }
}