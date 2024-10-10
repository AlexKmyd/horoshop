<?php


namespace App\Core\FacadeBundle\v1\Services;


use App\Core\FacadeBundle\v1\Requests\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

class RequestConverter
{
    public function convert(Request $request, string $class) :AbstractRequest
    {
        try{
            switch ($request->getRequestFormat()){
                case 'json':
                    return new $class(json_decode($request->getContent(), true));
                    break;
                //
            }
            throw new \Exception("Undefined format");
        } catch (\Throwable $e){
            return new $class;
        }
    }
}