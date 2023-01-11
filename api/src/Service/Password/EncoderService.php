<?php

namespace App\Service\Password;

use App\Exceptions\Password\PasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncoderService
{
    private const MINIMUN_LENGTH = 6;
    private UserPasswordEncoderInterface $userPasswordEncoder;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder,
                                UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function generateEncodedPassword(UserInterface $user, string $password)
    {
        if (self::MINIMUN_LENGTH > strlen($password)) {
            throw PasswordException::invalidLength();
        }

        $this->userPasswordEncoder->encodePassword($user, $password);
       return $this->userPasswordHasher->hashPassword($user, $password);
    }

    public function isValidPassword(User $user, string $oldPassword): bool
    {
        $this->userPasswordEncoder->isPasswordValid($user, $oldPassword);
       return $this->userPasswordHasher->isPasswordValid($user, $oldPassword);
    }
}