<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Notice;
use BackendBundle\Entity\Log;
use FrontendBundle\Entity\ResponseRest;

class NoticeController extends Controller
{
    public function getNoticeAction(){
        
        header("Access-Control-Allow-Origin: *");

        $em = $this->getDoctrine()->getManager();
        $notice = $em->getRepository('BackendBundle:Notice')->findBy(array(), array('createAt'=>'desc'));

        $arr = [];
        $arr1 = [];

        foreach($notice as $n){

            $arr1['id'] = $n->getId();
            $arr1['title'] = $n->getTitle();
            $arr1['firstname'] = $n->getUser()->getFirstname();
            $arr1['lastname'] = $n->getUser()->getLastname();
            $arr1['description'] = $n->getDescription();
            $arr1['imgsrc'] = $n->getImgSrc();
            $arr1['date'] = $n->getCreateAt()->format('d/m/y h:i')."hs";;
            $arr[] = $arr1;
        }

        return ResponseRest::returnOk($arr);

    }

    public function createNoticeAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $title = $request->get("title");
        $description = $request->get("description");
        $id = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();

        $notice = new Notice();
        $user = $em->getRepository('BackendBundle:User')->findOneById($id);

        $notice->setTitle($title);
        $notice->setDescription($description);
        $notice->setUser($user);
        
        $em->persist($notice);
        $em->flush();
        $this->createLog("new",$user);

        return ResponseRest::returnOk("ok");
    }

    public function deleteNoticeAction(Request $request){

        header("Access-Control-Allow-Origin: *");
        $id = $request->get("id");
        $user_id = $request->get("user_id");

        $em = $this->getDoctrine()->getManager();

        $notice = $em->getRepository('BackendBundle:Notice')->findOneById($id);

        $em->remove($notice);
        $em->flush();   
        $this->createLog("delete",$em->getRepository('BackendBundle:User')->findOneById($user_id));

        return ResponseRest::returnOk("ok");
    }

    private function createLog($type, $user){
        $log = new Log();
        $log = $log->createLog($type,"nota",$user);
        $this->getDoctrine()->getManager()->persist($log);
        $this->getDoctrine()->getManager()->flush();
    }


}