<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Spend;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class SpendController extends Controller
{
    public function getSpendByMonthAction(Request $request, $month){
        
        header("Access-Control-Allow-Origin: *");

        $arr = [];

        $em = $this->getDoctrine()->getManager();
        $spend = $this->getDoctrine()->getEntityManager()
        ->createQuery('SELECT s.total, s.createAt FROM BackendBundle:Spend s'
        )->getResult();

        $total = 0;
        foreach($spend as $s){
            if($month == $s["createAt"]->format('m')){
                $total += $s["total"];
            }
        }

        $arr["total"] = $total;

        return ResponseRest::returnOk($arr);

    }

    public function getSpendByMonthAllAction(Request $request, $month){
        
        header("Access-Control-Allow-Origin: *");

        $arr = [];
        $arr1 = [];

        $em = $this->getDoctrine()->getManager();
        $spend = $this->getDoctrine()->getEntityManager()
        ->createQuery('SELECT s FROM BackendBundle:Spend s'
        )->getResult();

        foreach($spend as $s){
            if($month == $s->getCreateAt()->format('m')){
                $arr1['id'] = $s->getId();
                $arr1['title'] = $s->getTitle();
                $arr1['price'] = $s->getPrice();
                $arr1['total'] = $s->getTotal();
                $arr1['count'] = $s->getCount();
                $arr[] = $arr1;
            }
        }


        return ResponseRest::returnOk($arr);

    }

    public function setPriceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $title = $request->get("title");
        $price = $request->get("price");
        $count = $request->get("count");
        $type = $request->get("type");
        $id = $request->get("user_id");

        $spendObj = new Spend();

        $spendObj->setTitle($title);
        $spendObj->setPrice($price);
        $spendObj->setCount($count);
        $spendObj->setTotal($count * $price);
        $spendObj->setType($type);

        $em = $this->getDoctrine()->getManager();
        $em->persist($spendObj);
        $em->flush();
        $this->createLog("new",$em->getRepository('BackendBundle:User')->findOneById($id));

        return ResponseRest::returnOk("ok");
    }

    public function deletePriceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $user_id = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();

        $spendObj = $em->getRepository('BackendBundle:Spend')->findOneById($id);

        $em->remove($spendObj) ;
        $em->flush();   
        $this->createLog("delete",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");
    }

    private function createLog($type, $user){
        $log = new Log();
        $log = $log->createLog($type,"recaudacion",$user);
        $this->getDoctrine()->getManager()->persist($log)->flush();
        $this->getDoctrine()->getManager()->flush();
    }

}