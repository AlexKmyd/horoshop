<?php


namespace App\Core\FacadeBundle\v1\Services;


use App\Core\FacadeBundle\v1\Requests\CreateUserRequest;
use App\Core\FacadeBundle\v1\Requests\DeleteUserRequest;
use App\Core\FacadeBundle\v1\Requests\GetUserRequest;
use App\Core\FacadeBundle\v1\Requests\ModifyUserRequest;
use App\Core\FacadeBundle\v1\Services\Acl\AbstractAclUnit;
use App\Core\UserBundle\Services\UserManagerInterface;

class AclService
{
    public function __construct(
        protected UserManagerInterface $userManager)
    {
    }

    /**
     * @param GetUserRequest $request
     * @param AbstractAclUnit $acl
     * @return mixed
     * @throws \Exception
     */
    public function getUser(GetUserRequest $request, AbstractAclUnit $acl)
    {
        if ($acl->allowedView()){
            return $this->userManager->get($request->getId());
        }
        throw new \Exception('Have no permissions');
    }

    /**
     * @param CreateUserRequest $request
     * @param AbstractAclUnit $acl
     * @return mixed
     * @throws \Exception
     */
    public function createUser(CreateUserRequest $request, AbstractAclUnit $acl)
    {
        if ($acl->hasFullControl() || $acl->allowedCreate()){
            return $this->userManager->create($request->getLogin(), $request->getPassword(), $request->getPhone());
        }
        throw new \Exception('Have no permissions');
    }

    /**
     * @param ModifyUserRequest $request
     * @param AbstractAclUnit $acl
     * @return mixed
     * @throws \Exception
     */
    public function modifyUser(ModifyUserRequest $request, AbstractAclUnit $acl)
    {
        if ($acl->allowedModify()){
            return $this->userManager->modify($request->getId(), $request->getLogin(), $request->getPassword(), $request->getPhone());
        }
        throw new \Exception('Have no permissions');
    }

    /**
     * @param DeleteUserRequest $request
     * @param AbstractAclUnit $acl
     * @return mixed
     * @throws \Exception
     */
    public function deleteUser(DeleteUserRequest $request, AbstractAclUnit $acl)
    {
        if ($acl->allowedDelete()){
            return $this->userManager->delete($request->getId());
        }
        throw new \Exception('Have no permissions');
    }
}