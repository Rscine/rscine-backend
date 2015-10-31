<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerBuilder;
use Doctrine\ORM\EntityNotFoundException;

class UserController extends FOSRestController
{


    /**
     * Récupère tous les utilisateurs
     * GET api/users
     * @Rest\View()
     *
     * @return [type] [description]
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();
        return $users;
    }

    /**
     * [postUsersAction description]
     * @return [type] [description]
     */
    public function postUsersAction()
    {

    }

    /**
     * Récupère un ustilisateur suivant le slug
     * GET api/users/{slug}
     * @Rest\View()
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    /**
     * Modifie un utilisateur
     * PATCH api/users/{slug}
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function patchUserAction(Request $request, User $user)
    {
        $editForm = $this->createEditForm($user);

        $editForm->submit($request->request->get($editForm->getName()));

        if ($editForm->isValid() && $editForm->isSubmitted()) {

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return  $user;
        }

        return $editForm->getErrors();
    }

    /**
     * Modifie un utilisateur
     * PUT api/users/{slug}
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function putUserAction(Request $request, $user)
    {
        $editForm = $this->createEditForm($user);

        $editForm->submit($request->request->get($editForm->getName()));

        if ($editForm->isValid() && $editForm->isSubmitted()) {

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return  null;
        }

        return $editForm->getErrors();
    }

    /**
     * Retourne les options possibles pour un utilisateur
     * OPTIONS api/users
     *
     * @return [type]       [description]
     */
    public function optionsUsersAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST');

        return $response;
    }

    /**
     * Retourne les options possibles pour un utilisateur
     * OPTIONS api/users
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @return [type]       [description]
     */
    public function optionsUserAction(User $user)
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST');

        return $response;
    }

    /**
     * Retourne le formulaire d'édition d'un utilisateur ()
     *
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function createEditForm(User $user)
    {
        $editForm = $this->createForm(new RegistrationType(), $user);

        return $editForm;
    }

}
