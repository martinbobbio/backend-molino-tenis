<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Event;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class EventController extends Controller
{
    public function getEventsAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $event = $em->createQuery('SELECT e FROM BackendBundle:Event e ORDER BY e.id DESC')->setMaxResults(150)->getResult();
        $typeEvent = $em->getRepository('BackendBundle:TypeEvent')->findAll();

        $arr = [];
        $arr1 = [];

        foreach($event as $e){

            $arr1['id'] = $e->getId();
            $arr1['title'] = $e->getTitle();
            $arr1['type'] = $e->getType();
            $arr1['hours'] = $e->getHours();
            $arr1['hour'] = $e->getHour();
            $arr1['is_suspended'] = $e->getIsSuspended();
            $arr1['date'] = $e->getDateMatch()->format('Y-m-d');
            foreach($typeEvent as $te)
                if($e->getType() == $te->getTitle())
                    $arr1['color'] = $te->getColor();

            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);

    }

    public function getTypeEventsAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $type_event = $em->getRepository('BackendBundle:TypeEvent')->findAll();

        $arr = [];
        $arr1 = [];

        foreach($type_event as $e){

            $arr1['title'] = $e->getTitle();
            $arr1['id'] = $e->getId();
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);

    }

    public function createEventAction(Request $request){
        
        header("Access-Control-Allow-Origin: *");
        $user_id = $request->get("user_id");
        $title = $request->get("title");
        $type = $request->get("type");
        $hour = $request->get("hour");
        $hours = $request->get("hours");
        $date = $request->get("date");

        $em = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setIsSuspended(0);
        $event->setTitle($title);
        $event->setType($type);
        $event->setDateMatch(new \DateTime($date));
        $event->setHours($hours);
        $event->setHour($hour);
        
        $em->persist($event);
        $em->flush();
        $this->createLog("new",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");

    }

    public function editEventAction(Request $request){
        
        header("Access-Control-Allow-Origin: *");
        $user_id = $request->get("user_id");
        $id = $request->get("id");
        $title = $request->get("title");
        $type = $request->get("type");
        $hour = $request->get("hour");
        $hours = $request->get("hours");
        $date = $request->get("date");

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('BackendBundle:Event')->findOneById($id);

        $event->setIsSuspended(0);
        $event->setTitle($title);
        $event->setType($type);
        $event->setDateMatch(new \DateTime($date));
        $event->setHours($hours);
        $event->setHour($hour);
        
        $em->persist($event);
        $em->flush();
        $this->createLog("edit",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");

    }

    public function deleteEventAction(Request $request){
        
        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $user_id = $request->get("user_id");
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('BackendBundle:Event')->findOneById($id);

        $em->remove($event) ;
        $em->flush();   
        $this->createLog("delete",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");
    }

    public function getEventAction(Request $request){
        
        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('BackendBundle:Event')->findOneById($id);

        $arr = [];

        $arr['id'] = $e->getId();
        $arr['title'] = $e->getTitle();
        $arr['type'] = $e->getType();
        $arr['hours'] = $e->getHours();
        $arr['hour'] = $e->getHour();
        $arr['is_suspended'] = $e->getIsSuspended();
        $arr['date'] = $e->getDateMatch()->format('Y-m-d');

        return ResponseRest::returnOk($arr);
    }

    public function suspendEventAction(Request $request){
        
        header("Access-Control-Allow-Origin: *");
        $user_id = $request->get("user_id");
        $id = $request->get("id");
        $suspended = $request->get("is_suspended");

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('BackendBundle:Event')->findOneById($id);
        $event->setIsSuspended($suspended);
        
        $em->persist($event);
        $em->flush();
        $this->createLog("edit",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");

    }

    private function createLog($type, $user){
        $log = new Log();
        $log = $log->createLog($type,"evento",$user);
        $this->getDoctrine()->getManager()->persist($log);
        $this->getDoctrine()->getManager()->flush();
    }


}