<?php


namespace App\Core\FacadeBundle\v1\Services\Acl;


class AclAdmin extends AbstractAclUnit
{
    public function allowedCreate(): bool
    {
        return true;
    }

    public function allowedDelete(): bool
    {
        return true;
    }

    public function allowedModify(): bool
    {
        return true;
    }

    public function allowedView(): bool
    {
        return true;
    }
}