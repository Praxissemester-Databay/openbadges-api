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
        $json = JsonService::getInstance()->objectToApiJson($object, $resource,
            $request->getSchemeAndHttpHost());
        if(ResourceIdentifierService::getInstance()->isNotAUser($request)) {
            return new Response(json_encode($json, JSON_THROW_ON_ERROR));
        }
        // TODO: render Badge
        return $this->render("resource/$resource.html.twig", [
            'data' => $object
        ]);
    }
}
