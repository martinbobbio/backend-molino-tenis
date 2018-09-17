<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Player;

class PlayerController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(Request $request){
        
        $con = $this->getDoctrine()->getManager();
        $playerQuery = $con->getRepository('BackendBundle:Player')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','player_delete');

        $paginator  = $this->get('knp_paginator');
        $player = $paginator->paginate(
          $playerQuery,
          $request->query->getInt('page', 1),
          15);

        return $this->render('player/index.html.twig', array('player' => $player,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Player $player){
        
        $editForm = $this->createForm('BackendBundle\Form\PlayerType', $player);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if(!empty($player->fileIds)){
                $player->setImgSrc("uploads/player/".$player->fileIds);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_index', array('id' => $player->getId()));
        }

        return $this->render('player/edit.html.twig', array(
            'player' => $player,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm('BackendBundle\Form\PlayerType', $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!empty($player->fileIds)){
                $player->setImgSrc("uploads/player/".$player->fileIds);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/new.html.twig', array(
            'player' => $player,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository('BackendBundle:Player')->find($id);

        $form = $this->createCustomForm($player->getId(),'DELETE', 'player_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            if($request->isXMLHttpRequest()){
                
                $em->remove($player) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1,'message' => 'Noticia borrado')),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($player) ;
            $em->flush();

            return $this->redirectToRoute('player_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }
}