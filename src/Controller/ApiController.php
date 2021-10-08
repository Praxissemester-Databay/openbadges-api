<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ResourceIdentifierService;
use App\Services\JsonService;

class ApiController extends AbstractController
{
    /**
     * @Route("/badge_api/{resource}/{id}", name="api")
     */
    public function index($resource, $id, Request $request): Response
    {
        try {
            [$class, ] = ResourceIdentifierService::getInstance()->identify($resource);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage());
        }
        $object = $this->getDoctrine()->getRepository($class)->find($id);
        if(!$object) {
            return new Response("Could not find Assignment with id {$id}");
        }
        return new Response(json_encode(JsonService::getInstance()->objectToApiJson($object, $resource, $request->getSchemeAndHttpHost()), JSON_THROW_ON_ERROR));
    }
}
