<?php

namespace LGDD\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use LGDD\SiteBundle\Entity\Article;
use LGDD\SiteBundle\Entity\Categorie;

/*
 *
 * Conctroleur servant pour la gestion de la partie Admin
 *
 */

// http://www.letuyau.net/2011/12/le-crud-ou-comment-creer-une-maquette-rapidement/

class AdministrationController extends Controller
{
 
 	public function indexAction() {
   
    
	    $manager = $this->getDoctrine()->getManager();
	    $repositoryCategorie = $manager->getRepository('LGDDSiteBundle:Categorie');
	    $liste_normal_menu = $repositoryCategorie->getFirstLevel();

	    $repositoryAnnexe = $manager->getRepository('LGDDSiteBundle:Annexe');
	    $liste_annexe_menu = $repositoryAnnexe->findAll();

    	return $this->render('LGDDUserBundle:Admin:admin.html.twig', array(
    		'liste_normal_menu' => $liste_normal_menu,
    		'liste_annexe_menu' => $liste_annexe_menu
   		));
	}

// fonction Article
	public function ajouterArticleAction() {

	    $article = new Article;
	    
	    $form  =  $this ->createFormBuilder($article)
	    				->add('titre','text')
	    				->add('contenu','textarea')
	    				->getForm();
	   
	    if ($this->get('request')->getMethod() == 'POST') {

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

//fonction Categorie
  	public function ajouterCategorieAction(){ 
  		$categorie = new Categorie;
	    
	    $form  =  $this ->createFormBuilder($categorie)
	    				->add('titre','text')
	    				->add('parent','entity', array(
														  'class'    => 'LGDDSiteBundle:Categorie',
														  'property' => 'titre'
														  ))
	    				->getForm();
	   
	    if ($this->get('request')->getMethod() == 'POST') {

	    	$form->bind($request);
	    	if($form->isValid()){
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($categorie);
	    		$em->flush();
	    	}
	    
	      	$this->get('session')->getFlashBag()->add('info', 'Categorie bien enregistré');
	      	return $this->redirect( $this->generateUrl('lgdd_admin_homepage', array('id' => $categorie->getId())) );
	    }

 		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    	// - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

	    return $this->render('LGDDUserBundle:Admin:ajouter.html.twig', array(
    		'form' => $form->createView(),
  		));
  	}

  	public function modifierCategorieAction(Categorie $categorie) {

	    $form  =  $this ->createFormBuilder($categorie)
	    				->add('titre','text')
	    				->add('parent', 'entity', array(
														  'class'    => 'LGDDSiteBundle:Categorie',
														  'property' => 'titre'
														  ))
	    				->getForm();
	   
    	$request = $this->get('request');
	    if ($request->getMethod() == 'POST') {

	    	$form->bind($request);
	    	if($form->isValid()){
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($categorie);
	    		$em->flush();
	    	}
	    
	      	$this->get('session')->getFlashBag()->add('info', 'Article bien modifié');
	      	return $this->redirect( $this->generateUrl('lgdd_admin_homepage', array('id' => $categorie->getId())) );
	    }

 		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    	// - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

	    return $this->render('LGDDUserBundle:Admin:modifier.html.twig', array(
    		'form' => $form->createView(),
  		));
  	}

  	public function supprimerCategorieAction(Categorie $categorie) {

  		$form = $this->createFormBuilder()->getForm();

		$request = $this->getRequest();
	    if ($request->getMethod() == 'POST') {

	      $form->bind($request);
	      if ($form->isValid()) {
	        // On supprime l'article
	        $em = $this->getDoctrine()->getManager();
	        $em->remove($categorie);
	        $em->flush();

       		$this->get('session')->getFlashBag()->add('info', 'Categorie bien supprimé');	        
        	return $this->redirect($this->generateUrl('lgdd_admin_homepage'));
	      }
	    }

	    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
	    return $this->render('LGDDUserBundle:Admin:supprimer.html.twig', array(
	      'categorie' => $categorie,
	      'form'    => $form->createView()
	    ));
  	}

//function Annexe


//function All (in the future)
  	public function supprimerAction($id,$type) {

	    // $manager = $this->getDoctrine()->getManager();

  		if($type == 'categorie'){
  			$repositoryCategorie = $manager->getRepository('LGDDSiteBundle:Categorie');
      		$element = $repositoryCategorie->findOneById($id);
  		}elseif($type == 'article'){
  			$repositoryArticle = $manager->getRepository('LGDDSiteBundle:Article');
      		$element = $repositoryArticle->findOneById($id);
  		}elseif($type == 'annexe'){
  			$repositoryAnnexe = $manager->getRepository('LGDDSiteBundle:Annexe');
      		$element = $repositoryAnnexe->findOneById($id);
  		}

  		$form = $this->createFormBuilder()->getForm();

		$request = $this->getRequest();
	    if ($request->getMethod() == 'POST') {

	      $form->bind($request);
	      if ($form->isValid()) {

	        $em = $this->getDoctrine()->getManager();
	        $em->remove($element);
	        $em->flush();

       		$this->get('session')->getFlashBag()->add('info', 'Categorie bien supprimé');	        
        	return $this->redirect($this->generateUrl('lgdd_admin_homepage'));
	      }
	    }

	    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
	    return $this->render('LGDDUserBundle:Admin:supprimer.html.twig', array(
	      'element' => $element,
	      'form'    => $form->createView()
	    ));
  	}

}