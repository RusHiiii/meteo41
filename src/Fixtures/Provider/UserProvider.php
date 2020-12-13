<?php


namespace App\Fixtures\Provider;

use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class UserProvider extends BaseProvider
{
    /**
     * @var NativePasswordEncoder
     */
    private $passwordEncoder;

    /**
     * UserProvider constructor.
     * @param NativePasswordEncoder $passwordEncoder
     */
    public function __construct(
        NativePasswordEncoder $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encodePassword(string $password)
    {
        return $this->passwordEncoder->encodePassword($password, null);
    }
}