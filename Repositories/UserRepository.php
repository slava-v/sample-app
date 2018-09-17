<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:54 PM
 */

namespace FinApiDemo\Repositories;

use FinApiDemo\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    private $storageDir;

    public function __construct($storageDir)
    {
        $this->storageDir = $storageDir;
    }

    function getById($userId)
    {
        // TODO: Implement getById() method.

        $data = file_get_contents($this->storageDir . $userId . '.json');

        if (!empty($data) && ($userData = json_decode($data)) != null){
            return $userData;
        }

        return null;
    }

    public function isTokenValid()
    {
        return false;
    }
}