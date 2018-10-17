<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Ranking;

class RankingController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(Request $request){
        
        $con = $this->getDoctrine()->getManager();
        $ranking = $con->getRepository('BackendBundle:Ranking')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','ranking_delete');

        return $this->render('ranking/index.html.twig', array('ranking' => $ranking,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Ranking $ranking){
        
        $editForm = $this->createForm('BackendBundle\Form\RankingType', $ranking);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ranking_index', array('id' => $ranking->getId()));
        }

        return $this->render('ranking/edit.html.twig', array(
            'ranking' => $ranking,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $ranking = new Ranking();
        $form = $this->createForm('BackendBundle\Form\RankingType', $ranking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($ranking);
            $em->flush();

            return $this->redirectToRoute('ranking_index');
        }

        return $this->render('ranking/new.html.twig', array(
            'ranking' => $ranking,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ranking = $em->getRepository('BackendBundle:Ranking')->find($id);

        $form = $this->createCustomForm($ranking->getId(),'DELETE', 'ranking_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $em->remove($ranking) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($ranking) ;
            $em->flush();

            return $this->redirectToRoute('ranking_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

}