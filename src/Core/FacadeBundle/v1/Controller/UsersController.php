<?php


namespace App\Core\FacadeBundle\v1\Controller;


use App\Core\FacadeBundle\v1\Interfaces\UserManagerInterface;
use App\Core\FacadeBundle\v1\Requests\CreateUserRequest;
use App\Core\FacadeBundle\v1\Requests\DeleteUserRequest;
use App\Core\FacadeBundle\v1\Requests\GetUserRequest;
use App\Core\FacadeBundle\v1\Requests\ModifyUserRequest;
use App\Core\FacadeBundle\v1\Services\AclService;
use App\Core\FacadeBundle\v1\Services\RequestConverter;
use App\Core\FacadeBundle\v1\Services\TokenAccessHandler;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsersController extends AbstractController
{
    public function __construct(
        protected RequestConverter $converter,
        protected ValidatorInterface $validator,
        protected TokenAccessHandler $accessHandler,
        protected AclService $aclService,
        protected SerializerInterface $serializer
    )
    {
    }

    #[Route('/v1/api/users/{id}', methods: 'GET')]
    public function get($id, Request $request)
    {
        $getRequest = new GetUserRequest();
        $getRequest->setId(intval($id));
        try{
            $acl = $this->getAcl($request);
            $user = $this->aclService->getUser($getRequest, $acl);
            $asArray = $this->serializer->toArray($user);
            return new JsonResponse(array_merge(['success' => true], $asArray), 200);
        } catch (\Throwable $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    #[Route('/v1/api/users', methods: 'POST', format: "json")]
    public function create(Request $request)
    {
        $createRequest = $this->converter->convert($request, CreateUserRequest::class);

        $errors = $this->validator->validate($createRequest);
        if ($errors->count()){
            return new JsonResponse(['success' => false, 'message' => (string)$errors->get(0)], 400);
        }

        try{
            $acl = $this->getAcl($request);
            $id = $this->aclService->createUser($createRequest, $acl);
            return new JsonResponse(['success' => true, 'id' => $id], 200);
        } catch (\Throwable $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    #[Route('/v1/api/users/{id}', methods: 'DELETE')]
    public function delete($id, Request $request)
    {
        $deleteRequest = new DeleteUserRequest();
        $deleteRequest->setId(intval($id));

        try{
            $acl = $this->getAcl($request);
            $this->aclService->deleteUser($deleteRequest, $acl);
            return new JsonResponse(['success' => true], 200);
        } catch (\Throwable $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    #[Route('/v1/api/users/{id}', methods: 'PUT', format: "json")]
    public function modify($id, Request $request)
    {
        /** @var ModifyUserRequest $modifyRequest */
        $modifyRequest = $this->converter->convert($request, ModifyUserRequest::class);
        $modifyRequest->setId($id);

        $errors = $this->validator->validate($modifyRequest);
        if ($errors->count()){
            return new JsonResponse(['success' => false, 'message' => (string)$errors->get(0)], 400);
        }

        try{
            $acl = $this->getAcl($request);
            $user = $this->aclService->modifyUser($modifyRequest, $acl);
            $asArray = $this->serializer->toArray($user);
            return new JsonResponse(array_merge(['success' => true], $asArray), 200);
        } catch (\Throwable $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    protected function getAcl(Request $request)
    {
        return $this->accessHandler->getAcl($request->headers->get('Authorization'));
    }
}