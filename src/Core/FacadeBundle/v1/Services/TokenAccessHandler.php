<?php


namespace App\Core\FacadeBundle\v1\Services;


use App\Core\FacadeBundle\v1\Services\Acl\AbstractAclUnit;
use App\Core\FacadeBundle\v1\Services\Acl\AclFactory;

class TokenAccessHandler
{
    /**
     * @param string $accessToken
     * @return AbstractAclUnit
     * @throws \Exception
     */
    public function getAcl(string $accessToken) :AbstractAclUnit
    {
        if (strpos($accessToken, 'Bearer') == -1){
            throw new \Exception("Invalid token format");
        }
        $token = explode(" ", $accessToken);
        return AclFactory::createAcl(trim($token[1] ?? ""));
    }
}