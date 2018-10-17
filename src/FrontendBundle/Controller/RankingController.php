<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class RankingController extends Controller
{
    public function getRankingsAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();

        $categoryA = $em->createQuery("SELECT r FROM BackendBundle:Ranking r WHERE r.category = 'Categoria A' ORDER BY r.points DESC")->getResult();
        $categoryB = $em->createQuery("SELECT r FROM BackendBundle:Ranking r WHERE r.category = 'Categoria B' ORDER BY r.points DESC")->getResult();
        $categoryC = $em->createQuery("SELECT r FROM BackendBundle:Ranking r WHERE r.category = 'Categoria C' ORDER BY r.points DESC")->getResult();
        
        $arr = [];

        $arr["category_a"] = $this->getByCategory($categoryA);
        $arr["category_b"] = $this->getByCategory($categoryB);
        $arr["category_c"] = $this->getByCategory($categoryC);

        return ResponseRest::returnOk($arr);

    }

    private function getByCategory($category){

        $arr = [];
        $arr1 = [];

        foreach($category as $c){

            $arr1['id'] = $c->getId();
            $arr1['points'] = $c->getPoints();
            $arr1['playerName'] = $c->getPlayer()->getName();
            $arr1['playerPhoto'] = $c->getPlayer()->getImgSrc();
            $arr[] = $arr1;
        }

        return $arr;

    }

}