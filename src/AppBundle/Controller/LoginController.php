<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {
        
        if(!$request->isMethod('POST')){
            return $this->redirectToRoute('index');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        
        if($error){
            return $this->redirectToRoute('index');
        }

    }

}
