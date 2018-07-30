<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class LogController extends Controller
{
    public function getLogsAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('BackendBundle:Log')->findBy(array(), array('createAt'=>'desc'));

        $arr = [];
        $arr1 = [];

        foreach($log as $l){

            $arr1['title'] = $l->getTitle();
            $arr1['firstname'] = $l->getUser()->getFirstname();
            $arr1['lastname'] = $l->getUser()->getLastname();
            $arr1['date'] = $l->getCreateAt()->format('d/m/y h:i')."hs";
            $arr1['photo'] = $l->getUser()->getPhoto();
            if($l->getType()=="new")
                $arr1['color'] = "secondary";
            else if($l->getType()=="edit")
                $arr1['color'] = "primary";
            else if($l->getType()=="delete")
                $arr1['color'] = "danger";
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);

    }

}