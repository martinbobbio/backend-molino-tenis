<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Email;

class EmailController extends Controller
{
    public function indexAction(Request $request)
    {
        $con = $this->getDoctrine()->getManager();
        $email = $con->getRepository('BackendBundle:Email')->findAll();

        return $this->render('email/index.html.twig', array('email' => $email));
    }

}
