<?php

namespace LGDD\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use LGDD\SiteBundle\Entity\Article;

/*
 *
 * Conctroleur servant pour la gestion de la partie Admin
 *
 */



class AdministrationController extends Controller
{
 
 	public function indexAction() {
   
    	return $this->render('LGDDUserBundle:Admin:admin.html.twig', array(
      		// Valeur du précédent nom d'utilisateur entré par l'internaute
      		//'last_username' => $session->get(SecurityContext::LAST_USERNAME),
      		//'error'         => $error,
   		));
	}

	public function ajouterArticleAction() {

	    $article = new Article;
	    
	    $form  =  $this ->createFormBuilder($article)
	    				->add('titre','text')
	    				->add('contenu','textarea')
	    				->getForm();
	   
    	$request = $this->get('request');
	    if ($request->getMethod() == 'POST') {

	    	$form->bind($request);
	    	if($form->isValid()){
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($article);
	    		$em->flush();
	    	}
	    
	      	$this->get('session')->getFlashBag()->add('info', 'Article bien enregistré');
	      	return $this->redirect( $this->generateUrl('lgdd_admin_homepage', array('id' => $article->getId())) );
	    }

 		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    	// - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

	    return $this->render('LGDDUserBundle:Admin:ajouter.html.twig', array(
    		'form' => $form->createView(),
  		));
  	}

  	public function modifierArticleAction(Article $article) {

	    $form  =  $this ->createFormBuilder($article)
	    				->add('titre','text')
	    				->add('contenu','textarea')
	    				->add('parent', 'entity', array(
														  'class'    => 'LGDDSiteBundle:Article',
														  'property' => 'titre'
														  ))
	    				->getForm();
	   
    	$request = $this->get('request');
	    if ($request->getMethod() == 'POST') {

	    	$form->bind($request);
	    	if($form->isValid()){
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($article);
	    		$em->flush();
	    	}
	    
	      	$this->get('session')->getFlashBag()->add('info', 'Article bien modifié');
	      	return $this->redirect( $this->generateUrl('lgdd_admin_homepage', array('id' => $article->getId())) );
	    }

 		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    	// - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

	    return $this->render('LGDDUserBundle:Admin:modifier.html.twig', array(
    		'form' => $form->createView(),
  		));
  	}

  	public function supprimerArticleAction(Article $article) {
  		$form = $this->createFormBuilder()->getForm();

		$request = $this->getRequest();
	    if ($request->getMethod() == 'POST') {

	      $form->bind($request);
	      if ($form->isValid()) {
	        // On supprime l'article
	        $em = $this->getDoctrine()->getManager();
	        $em->remove($article);
	        $em->flush();

       		$this->get('session')->getFlashBag()->add('info', 'Article bien supprimé');	        
        	return $this->redirect($this->generateUrl('lgdd_admin_homepage'));
	      }
	    }

	    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
	    return $this->render('LGDDUserBundle:Admin:supprimer.html.twig', array(
	      'article' => $article,
	      'form'    => $form->createView()
	    ));
  	}

}