<?php


namespace App\Core\FacadeBundle\v1\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserRequest extends AbstractRequest
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(max:8)]
    protected $login;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(max:8)]
    protected $password;

    #[Assert\Length(max:8)]
    protected $phone;

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}