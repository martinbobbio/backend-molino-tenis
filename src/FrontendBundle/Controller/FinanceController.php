<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Finance;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class FinanceController extends Controller
{
    public function getFinancesAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $finance = $em->getRepository('BackendBundle:Finance')->findAll();

        $arr = [];
        $arr1 = [];

        foreach($finance as $f){

            $arr1['id'] = $f->getId();
            $arr1['title'] = $f->getTitle();
            $arr1['count'] = $f->getCount();
            $arr1['total'] = $f->getTotal();
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);


    }

    public function setFinanceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $title = $request->get("title");
        $count = $request->get("count");
        $total = $request->get("total");
        $id_user = $request->get("user_id");

        $finance = new Finance();

        $finance->setTitle($title);
        $finance->setCount($count);
        $finance->setTotal($total);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($finance);
        $em->flush();
        $this->createLog("new",$em->getRepository('BackendBundle:User')->findOneById($id_user));

        return ResponseRest::returnOk("ok");
    }

    public function changeFinanceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $value = $request->get("value");
        $id_user = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();
        $finance = $em->getRepository('BackendBundle:Finance')->findOneById($id);
        $finance->setCount($value);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($finance);
        $em->flush();
        $this->createLog("edit",$em->getRepository('BackendBundle:User')->findOneById($id_user));

        return ResponseRest::returnOk("ok");
    }

    public function deleteFinanceAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $user_id = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();

        $finance = $em->getRepository('BackendBundle:Finance')->findOneById($id);

        $em->remove($finance) ;
        $em->flush();   
        $this->createLog("delete",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");
    }

    private function createLog($type, $user){
        $log = new Log();
        $log = $log->createLog($type,"abono",$user);
        $this->getDoctrine()->getManager()->persist($log);
        $this->getDoctrine()->getManager()->flush();
    }


}