<?php

namespace LGDD\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LGDDSiteBundle:Accueil:index.html.twig');
    }

     public function voirAction($id){
        $repository = $this->getDoctrine()
                      	   ->getManager()
                           ->getRepository('LGDDSiteBundle:Article');
    	$article = $repository->find($id);
        
    	return $this->render('LGDDSiteBundle:Content:content.html.twig', array(
        	'article' => $article
    	));
    }
}
