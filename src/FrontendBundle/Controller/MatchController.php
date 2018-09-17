<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class MatchController extends Controller
{
    public function getMatchsAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();

        $matchAmistoso = $em->createQuery("SELECT m FROM BackendBundle:Match m WHERE m.type = 'Amistoso'")->getResult();
        $matchDesafio = $em->createQuery("SELECT m FROM BackendBundle:Match m WHERE m.type = 'Desafio'")->getResult();
        $matchTorneo = $em->createQuery("SELECT m FROM BackendBundle:Match m WHERE m.type = 'Torneo'")->getResult();
        
        $arr = [];

        $arr["partidos_amistosos"] = $this->getByMatchs($matchAmistoso);
        $arr["partidos_desafio"] = $this->getByMatchs($matchDesafio);
        $arr["partidos_torneo"] = $this->getByMatchs($matchTorneo);

        return ResponseRest::returnOk($arr);

    }

    private function getByMatchs($matchs){

        $arr = [];
        $arr1 = [];

        foreach($matchs as $m){

            $arr1['id'] = $m->getId();
            $arr1['title'] = $m->getTitle();
            $arr1['score'] = $m->getScore();
            $arr1['playerWin'] = $m->getPlayerWin()->getName();
            $arr1['playerLoss'] = $m->getPlayerLoss()->getName();
            $arr1['date'] = $m->getDateMatch()->format('d/m/y h:i')."hs";;
            $arr[] = $arr1;
        }

        return $arr;

    }

}