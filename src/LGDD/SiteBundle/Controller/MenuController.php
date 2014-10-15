<?php


namespace LGDD\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LGDD\SiteBundle\Entity\Annexe;
use LGDD\SiteBundle\Entity\Categorie;
use LGDD\SiteBundle\Entity\Article;

class MenuController extends Controller
{
  public function menuAction($id = 0)
  {
    
    $manager = $this->getDoctrine()->getManager();

    $repositoryCategorie = $manager->getRepository('LGDDSiteBundle:Categorie');
    $liste_normal_menu = $repositoryCategorie->getFirstLevel();

    $repositoryAnnexe = $manager->getRepository('LGDDSiteBundle:Annexe');
    $list_annexe = $repositoryAnnexe->findAllWithout($id);
    
      

    return $this->render('LGDDSiteBundle:Menu:menu.html.twig', array(
      'liste_normal_menu' => $liste_normal_menu,
      'liste_annexe' => $list_annexe
    ));
  }

  // href : http://stackoverflow.com/questions/22813242/symfony2-fetch-categories-and-subcategories-using-self-join

   
}

?>