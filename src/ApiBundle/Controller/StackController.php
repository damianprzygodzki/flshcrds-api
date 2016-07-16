<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Stack;
use ApiBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


/**
 * @Route("/stack")
 */
class StackController extends Controller
{

    /**
     * @Route("/new")
     * @Method("POST")
     *
     * return JsonResponse
     */
    public function createStackAction()
    {
        $stack = new Stack();

        $em = $this->getDoctrine()->getManager();
        $em->persist($stack);
        $em->flush();

        $serializer = $this->container->get('jms_serializer');
        $stack = $serializer->serialize($stack, 'json');

        return new Response($stack);
    }
    /**
     * @Route("/{stackUri}")
     * @Method("POST")
     *
     * return Response
     */
    public function getStackAction(Request $request, $stackUri)
    {
        $email = $request->request->get('email');
        $em = $this->getDoctrine()->getManager();

        $stack = $em->getRepository('ApiBundle:Stack')->findOneBy(array('uri' => $stackUri));
        if(!$stack){
             throw $this->createNotFoundException('The stack does not exist');
        }
        if($stack->getUser() && $stack->getUser()->getEmail() != $email){
            throw new AccessDeniedHttpException('Authentication is required to access this resource.');
        }

        $serializer = $this->container->get('jms_serializer');
        $stack = $serializer->serialize($stack, 'json');

        return new Response($stack);
    }
    /**
     * @Route("/{stackUri}/secure")
     * @Method("POST")
     *
     * return Response
     */
    public function secureAction(Request $request)
    {
        $email = $request->request->get('email');
        $stackUri = $request->request->get('uri');

        $em = $this->getDoctrine()->getManager();
        $stack = $em->getRepository('ApiBundle:Stack')->findOneBy(array('uri' => $stackUri));
        if(!$stack){
             throw $this->createNotFoundException('The stack does not exist');
        }

        $user = new User();
        $user->setEmail($email);
        $em->persist($user);

        $stack->setUser($user);
        $em->flush();

        $serializer = $this->container->get('jms_serializer');
        $user = $serializer->serialize($user, 'json');

        return new Response($user);
    }
}
