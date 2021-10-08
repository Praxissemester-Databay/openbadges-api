<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Issuer;
use App\Form\IssuerType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BadgeType;
use App\Entity\Badge;
use App\Entity\Recipient;
use App\Form\RecipientType;
use App\Entity\Assignment;
use App\Form\AssignmentType;
use PHPUnit\Util\Json;
use App\Services\JsonService;
use App\Services\ResourceIdentifierService;

class DefaultController extends AbstractController
{
    /**
     * @Route("/view/{resource}/{id}", name="viewResource")
     */
    public function viewAssignment($resource, $id) : Response
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
        return new Response(json_encode(JsonService::getInstance()->objectToJson($object, $resource), JSON_THROW_ON_ERROR));
    }

    /**
     * @Route("/create/{resource}", name="createResource")
     */
    public function createIssuer($resource, Request $request) : Response
    {
        try {
            [, $type] = ResourceIdentifierService::getInstance()->identify($resource);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage());
        }
        $form = $this->createForm($type);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $object = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($object);
            $entityManager->flush();
            return $this->redirectToRoute('viewResource', ['resource' => $resource,'id' => $object->getId()]);
        }
        return $this->renderForm('form/default.html.twig', [
            'form' => $form
        ]);
    }

}
