<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;



class ProductController extends Controller{
    
    private $productsOnPage = 10;
    
    /**
     * @Route("/{page}",
     *      name="index",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template()
     */
    public function indexAction($page){
        
        $ProductRepo = $this->getDoctrine()->getRepository('AppBundle:Product');        
        $allProductsQuery = $ProductRepo->getAllOrderByDateQuery('DESC');
        
        $Paginator = $this->get('knp_paginator');
        $pagination = $Paginator->paginate($allProductsQuery, $page, $this->productsOnPage);        
        
        $results = count($pagination);
        if($page > 1 && !$results){
            throw $this->createNotFoundException('Podana strona nie istnieje');
        }
        
        return [
            'pagination' => $pagination
        ];
    }
}