<?php

namespace LGDD\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LGDD\SiteBundle\Entity\Annexe;
use LGDD\SiteBundle\Entity\Article;

class DefaultController extends Controller
{
    
    public function voirArticleAction(Article $article){
      $manager = $this->getDoctrine()
                      ->getManager();

      $repositoryCategorie = $manager->getRepository('LGDDSiteBundle:Categorie');
      $liste_first_categorie = $repositoryCategorie->getFirstLevel();
        
      return $this->render('LGDDSiteBundle:Content:content.html.twig', array(
          'article' => $article,
          'categories' => $liste_first_categorie
      ));
    }

    public function voirAnnexeAction(Annexe $annexe){
        
    	return $this->render('LGDDSiteBundle:Annexe:annexe.html.twig', array(
          'annexe' => $annexe
      ));
    }
}
