<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Prices;
use BackendBundle\Entity\Log;
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

    public function setPriceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $title = $request->get("title");
        $price = $request->get("price");
        $type = $request->get("type");
        $id = $request->get("user_id");

        $priceObj = new Prices();

        $priceObj->setTitle($title);
        $priceObj->setPrice($price);
        $priceObj->setType($type);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($priceObj);
        $em->flush();
        $this->createLog("new",$em->getRepository('BackendBundle:User')->findOneById($id));

        return ResponseRest::returnOk("ok");
    }

    public function editPriceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $title = $request->get("title");
        $price = $request->get("price");
        $type = $request->get("type");
        $id = $request->get("id");
        $user_id = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();

        $priceObj = $em->getRepository('BackendBundle:Prices')->findOneById($id);

        $priceObj->setTitle($title);
        $priceObj->setPrice($price);
        $priceObj->setType($type);
        
        $em->persist($priceObj);
        $em->flush();
        $this->createLog("edit",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");
    }

    public function deletePriceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $user_id = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();

        $priceObj = $em->getRepository('BackendBundle:Prices')->findOneById($id);

        $em->remove($priceObj) ;
        $em->flush();   
        $this->createLog("delete",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");
    }

    private function createLog($type, $user){
        $log = new Log();
        $log = $log->createLog($type,"precio",$user);
        $this->getDoctrine()->getManager()->persist($log);
        $this->getDoctrine()->getManager()->flush();
    }


}