<?php

namespace LGDD\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LGDDSiteBundle:Accueil:index.html.twig');
    }
}
