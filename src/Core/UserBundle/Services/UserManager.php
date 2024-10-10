<?php


namespace App\Core\UserBundle\Services;


use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager  implements UserManagerInterface
{
    public function __construct(
        protected UserRepository $repository,
        protected ValidatorInterface $validator
    )
    {
    }

    public function get(int $id)
    {
        $user = $this->repository->find($id);
        if (!$user) {
            throw new \Exception("User not found");
        }

        return $user;
    }

    /**
     * @param string $login
     * @param string $password
     * @param string|null $phone
     * @return \App\Entity\User
     * @throws \Exception
     */
    public function create(string $login, string $password, ?string $phone = null)
    {
        $user = $this->repository->create();
        $user->setLogin($login);
        $user->setPass($password);
        $user->setPhone($phone);

        $errors = $this->validator->validate($user);
        if ($errors->count()){
            throw new \Exception('Check attributes');
        }
        $this->repository->save($user);
        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->get($id);
        $this->repository->delete($user);
    }

    /**
     * @param int $id
     * @param string $login
     * @param string $password
     * @param string|null $phone
     * @return object
     * @throws \Exception
     */
    public function modify(int $id, string $login, string $password, ?string $phone = null)
    {
        $user = $this->repository->find($id);
        if (!$user){
            throw new \Exception("User not found");
        }
        $user->setLogin($login);
        $user->setPass($password);
        $user->setPhone($phone);

        $this->repository->save($user);
        return $user;
    }
}