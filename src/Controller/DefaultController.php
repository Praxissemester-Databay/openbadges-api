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

class DefaultController extends AbstractController
{
    /**
     * @Route("/view/assignment/{id}", name="viewAssignment")
     */
    public function viewAssignment($id) : Response
    {
        $assignment = $this->getDoctrine()->getRepository(Assignment::class)->find($id);
        if(!$assignment) {
            return new Response("Could not find Assignment with id {$id}");
        }
        return new Response(json_encode($this->objectToJson($assignment), JSON_THROW_ON_ERROR));
    }

    /**
     * @Route("/view/badge/{id}", name="viewBadge")
     */
    public function viewBadge($id) : Response
    {
        $badge = $this->getDoctrine()->getRepository(Badge::class)->find($id);
        if(!$badge) {
            return new Response("Could not find Badge with id {$id}");
        }
        return new Response(json_encode($this->objectToJson($badge), JSON_THROW_ON_ERROR));
    }

    /**
     * @Route("/view/issuer/{id}", name="viewIssuer")
     */
    public function viewIssuer($id) : Response
    {
        $issuer = $this->getDoctrine()->getRepository(Issuer::class)->find($id);
        if(!$issuer) {
            return new Response("Could not find Assignment with id {$id}");
        }
        return new Response(json_encode($this->objectToJson($issuer), JSON_THROW_ON_ERROR));
    }

    /**
     * @Route("/view/recipient/{id}", name="viewRecipient")
     */
    public function viewRecipient($id) : Response
    {
        $recipient = $this->getDoctrine()->getRepository(Recipient::class)->find($id);
        if(!$recipient) {
            return new Response("Could not find Recipient with id {$id}");
        }
        return new Response(json_encode($this->objectToJson($recipient), JSON_THROW_ON_ERROR));
    }

    public function objectToJson($object) : array {
        $json = [];
        foreach(get_class_methods($object) as $method) {
            if(!str_starts_with($method, 'get')) {
                continue;
            }
            if($object instanceof Assignment || $object instanceof Issuer || $object instanceof Recipient || $object instanceof Badge) {

            $res = $object->$method();
                $json[str_replace('get' , '', $method)] = is_object($res) ? $this->objectToJson($res) : $res;
        }
        }
        return $json;
    }

    /**
     * @Route("/create/issuer", name="createIssuer")
     */
    public function createIssuer(Request $request) : Response
    {
        $form = $this->createForm(IssuerType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Issuer $issuer */
            $issuer = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($issuer);
            $entityManager->flush();
            return $this->redirectToRoute('default', ['id' => $issuer->getId()]);
        }
        return $this->renderForm('form/default.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/create/badge", name="createBadge")
     */
    public function createBadge(Request $request) : Response
    {
        $form = $this->createForm(BadgeType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Badge $issuer */
            $badge = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($badge);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('default', ['id' => $badge->getId()]));
        }
        return $this->renderForm('form/default.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/create/recipient", name="createRecipient")
     */
    public function createRecipient(Request $request) : Response
    {
        $form = $this->createForm(RecipientType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Recipient $recipient */
            $recipient = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipient);
            $entityManager->flush();
            return $this->redirectToRoute('default', ['id' => $recipient->getId()]);
        }
        return $this->renderForm('form/default.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @Route("/create/assignment", name="createAssignment")
     */
    public function createAssignment(Request $request) : Response
    {
        $form = $this->createForm(AssignmentType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Assignment $assignment */
            $assignment = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($assignment);
            $entityManager->flush();
            return $this->redirectToRoute('default', ['id' => $assignment->getId()]);
        }
        return $this->renderForm('form/default.html.twig', [
            'form' => $form
        ]);
    }
}
