<?php


namespace App\Core\FacadeBundle\v1\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class ModifyUserRequest extends CreateUserRequest
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}