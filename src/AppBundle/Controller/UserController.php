<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/users")
     */
    public function getUsersAction(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $users;
    }

    /**
     * @Rest\Post("/users")
     */
    public function createUserAction(Request $request){
        $user = new User();

    }
}