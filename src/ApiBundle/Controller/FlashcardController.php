<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Flashcard;

/**
 * @Route("/flashcard")
 */
class FlashcardController extends Controller
{
    /**
     * @Route("/new")
     * @Method("POST")
     *
     * return Response
     */
    public function createFlashcardAction(Request $request)
    {
        $serializer = $this->container->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->all();

        $stack = $em->getRepository('ApiBundle:Stack')->findOneBy(array('uri' => $data['stackUri']));
        $flashcard = new Flashcard();
        $flashcard
            ->setStack($stack)
            ->setContent(json_decode($data['flashcard'])->content);

        $em->persist($flashcard);
        $em->flush();

        $flashcard->setTmpId(json_decode($data['flashcard'])->id);
        $flashcard = $serializer->serialize($flashcard, 'json');

        return new Response($flashcard);
    }

    /**
     * @Route("/{flashcard}")
     * @Method("DELETE")
     *
     * return Response
     */
    public function deleteFlashcardAction(Flashcard $flashcard)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($flashcard);
        $em->flush();

        return new Response(200);
    }
}
