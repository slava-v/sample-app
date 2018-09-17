<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:44 PM
 */

namespace FinApiDemo\Services;


use FinApiDemo\Entities\MyCo\User;
use FinApiDemo\Repositories\Interfaces\IUserRepository;
use FinApiDemo\Services\Interfaces\IUserService;

class UserService implements IUserService
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentUser()
    {
        return new User(
            'slava',
            'testpass',
            'email@mail.com',
            // null
            new \FinApiDemo\Entities\FinApi\User(
                "c390e74d-5f0c-460f-af75-bb6ade024650",
                "c412a02e-38e4-4377-8ade-e8de87dfa1f6",
                null,
                null,
                true
            )
        );
    }
}
