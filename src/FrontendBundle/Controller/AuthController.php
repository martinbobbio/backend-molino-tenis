<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FrontendBundle\Entity\ResponseRest;

class AuthController extends Controller
{
    public function checkLoginAction(Request $request){
        header("Access-Control-Allow-Origin: *");
        $username = $request->get("username");
        $password = $request->get("password");
        
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
  
        $user = $user_manager->loadUserByUsername($username);
        $encoder = $factory->getEncoder($user);
        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? true : false;
        
        $arr = [];
        $arr["status"] = $bool;
        if($bool == true){
            $arr["id"] = $user->getId();
            $arr["username"] = $user->getUsername();
            $arr["firstname"] = $user->getFirstname();
            $arr["lastname"] = $user->getLastname();
            $arr["photo"] = $user->getPhoto();
        }
        
        return ResponseRest::returnOk($arr);
    }


}