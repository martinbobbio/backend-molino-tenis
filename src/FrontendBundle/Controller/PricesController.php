<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Prices;
use FrontendBundle\Entity\ResponseRest;

class PricesController extends Controller
{
    public function getPricesAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $prices = $em->getRepository('BackendBundle:Prices')->findAll();

        $arr = [];
        $arr1 = [];

        foreach($prices as $p){

            $arr1['id'] = $p->getId();
            $arr1['title'] = $p->getTitle();
            $arr1['type'] = $p->getType();
            $arr1['price'] = $p->getPrice();
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);


    }


}