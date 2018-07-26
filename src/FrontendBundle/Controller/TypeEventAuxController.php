<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\TypeEvent;
use FrontendBundle\Entity\ResponseRest;

class TypeEventAuxController extends Controller
{
    public function getTypeEventAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $type_event = $em->getRepository('BackendBundle:TypeEvent')->findAll();

        $arr = [];
        $arr1 = [];

        foreach($type_event as $te){

            $arr1['id'] = $te->getId();
            $arr1['title'] = $te->getTitle();
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);

    }


}