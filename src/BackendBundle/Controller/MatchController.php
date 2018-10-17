<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Match;

class MatchController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(Request $request){
        
        $con = $this->getDoctrine()->getManager();
        $matchQuery = $con->getRepository('BackendBundle:Match')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','match_delete');

        $paginator  = $this->get('knp_paginator');
        $match = $paginator->paginate(
          $matchQuery,
          $request->query->getInt('page', 1),
          20);

        return $this->render('match/index.html.twig', array('match' => $match,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Match $match){
        
        $editForm = $this->createForm('BackendBundle\Form\MatchType', $match);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('match_index', array('id' => $match->getId()));
        }

        return $this->render('match/edit.html.twig', array(
            'match' => $match,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $match = new Match();
        $form = $this->createForm('BackendBundle\Form\MatchType', $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($match);
            $em->flush();

            return $this->redirectToRoute('match_index');
        }

        return $this->render('match/new.html.twig', array(
            'match' => $match,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $match = $em->getRepository('BackendBundle:Match')->find($id);

        $form = $this->createCustomForm($match->getId(),'DELETE', 'match_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $em->remove($match) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($match) ;
            $em->flush();

            return $this->redirectToRoute('match_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

}