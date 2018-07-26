<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Spend;
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
                $arr1['title'] = $s->getTitle();
                $arr1['price'] = $s->getPrice();
                $arr1['total'] = $s->getTotal();
                $arr1['count'] = $s->getCount();
                $arr[] = $arr1;
            }
        }


        return ResponseRest::returnOk($arr);

    }

}