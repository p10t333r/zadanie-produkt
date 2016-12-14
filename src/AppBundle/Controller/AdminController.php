<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Product;
use AppBundle\Form\Type\ProductType;

class AdminController extends Controller {

    /**
     * @Route("/admin", name="admin_index")
     * @Template()
     */
    public function indexAction() {

        return [];
    }

    /**
     * @Route("/admin/new-product", name="admin_new_product")
     * @Template()
     */
    public function newProductAction(Request $Request, Product $Product = null) {

        if (!$Product) {
            $Product = new Product();
        }

        $form = $this->createForm(ProductType::class, $Product);
        $form->handleRequest($Request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Product);
            $em->flush();
            
            $this->sendEmailConfirmation($Product);

            $this->addFlash(
                    'success', 'Produkt został dodany!'
            );

            return $this->redirectToRoute('index');
        }

        return [
            'form' => $form->createView()
        ];
    }

    private function sendEmailConfirmation(Product $Product) {
        
        $message = \Swift_Message::newInstance()
                ->setSubject('Potwierdzenie dodania produktu')
                ->setFrom('simple-shop@bs5.pl')
                ->setTo('wp_admin@bs5.pl')
                ->setBody("Do bazy został dodany nowy produkt: {$Product->getName()}");
        
        $this->get('mailer')->send($message);
    }

}
