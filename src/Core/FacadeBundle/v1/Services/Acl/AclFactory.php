<?php


namespace App\Core\FacadeBundle\v1\Services\Acl;


class AclFactory
{
    /**
     * @param string $tokenType
     * @return AbstractAclUnit
     * @throws \Exception
     */
    public static function createAcl(string $tokenType) :AbstractAclUnit
    {
        switch ($tokenType)
        {
            case TokenTypes::ACL_USER:
                return new AclUser();
            case TokenTypes::ACL_ADMIN:
                return new AclAdmin();
            default:
                throw new \Exception("Undefined token");
        }
    }
}