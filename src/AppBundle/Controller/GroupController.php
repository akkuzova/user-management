<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Group;
use AppBundle\Form\GroupType;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class GroupController extends FOSRestController
{
    /**
     * @ApiDoc
     * @Rest\Get("/groups")
     */
    public function getGroupsAction()
    {
        $groups = $this->getDoctrine()->getRepository(Group::class)->findAll();
        $view = $this->view($groups);
        $context = new Context();
        $context->setGroups(["list"]);
        $view->setContext($context);

        return $view;
    }

    /**
     * @ApiDoc
     * @Rest\Get("/groups/{id}", name="get_group")
     * @ParamConverter("group", class="AppBundle:Group")
     * @param Group $group
     * @return View
     */
    public function getGroupAction(Group $group)
    {
        $view = $this->view($group);
        $context = new Context();
        $context->setGroups(["details", "groupDetails"]);
        $view->setContext($context);
        return $view;
    }

    /**
     * @ApiDoc
     * @Rest\Post("/groups")
     * @param Request $request
     * @return View
     */
    public function createGroupAction(Request $request)
    {
        $group = new Group();

        $groupForm = $this->createForm(GroupType::class, $group);

        $groupForm->submit($request->request->all());

        if (!$groupForm->isValid()) {
            return $this->view($groupForm, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();

        return $this->view($group, Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl('get_group', array('id' => $group->getId()), true)
            ]
        );
    }

    /**
     * @ApiDoc
     * @Rest\Put("/groups/{id}")
     * @ParamConverter("group", class="AppBundle:Group")
     * @param Group $group
     * @param Request $request
     * @return View
     */
    public function updateGroupAction(Group $group, Request $request)
    {
        $groupForm = $this->createForm(GroupType::class, $group);

        $groupForm->submit($request->request->all());

        if (!$groupForm->isValid()) {
            return$this->view($groupForm, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();

        return $this->view($group, Response::HTTP_OK,
            [
                'Location' => $this->generateUrl('get_group', array('id' => $group->getId()), true)
            ]
        );
    }
}