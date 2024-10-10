<?php


namespace App\Core\UserBundle\Services;


interface UserManagerInterface
{
    public function create(string $login, string $password, ?string $phone = null);

    public function modify(int $id, string $login, string $password, ?string $phone = null);

    public function delete(int $id);

    public function get(int $id);
}