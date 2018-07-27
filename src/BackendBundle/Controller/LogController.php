<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Log;

class LogController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(Request $request){
        
        $con = $this->getDoctrine()->getManager();
        $logQuery = $con->getRepository('BackendBundle:Log')->findAll();

        $paginator  = $this->get('knp_paginator');
        $log = $paginator->paginate(
          $logQuery,
          $request->query->getInt('page', 1),
          20);

        return $this->render('log/index.html.twig', array('log' => $log));

    }

}