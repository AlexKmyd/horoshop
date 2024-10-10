<?php


namespace App\Core\FacadeBundle\v1\Services\Acl;


abstract class AbstractAclUnit
{
    abstract public function allowedCreate() :bool;

    abstract public function allowedView() :bool;

    abstract public function allowedModify() :bool;

    abstract public function allowedDelete() :bool;

    public function hasFullControl(): bool
    {
        return true;
    }
}