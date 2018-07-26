<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Event;
use FrontendBundle\Entity\ResponseRest;

class EventController extends Controller
{
    public function getEventsAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('BackendBundle:Event')->findAll();

        $arr = [];
        $arr1 = [];

        foreach($event as $e){

            $arr1['title'] = $e->getTitle();
            $arr1['type'] = $e->getType();
            $arr1['hours'] = $e->getHours();
            $arr1['hour'] = $e->getHour();
            $arr1['is_suspended'] = $e->getIsSuspended();
            $arr1['date_match'] = $e->getDateMatch()->format('Y-m-d');
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);

    }


}