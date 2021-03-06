<?php

namespace LGDD\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categorie
 *
 * @ORM\Table(name="lgdd_categorie")
 * @ORM\Entity(repositoryClass="LGDD\SiteBundle\Entity\CategorieRepository")
 */
class Categorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="LGDD\SiteBundle\Entity\Article", mappedBy="categorie")
     */
    private $articles; 
  
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="parent")
     */
    private $childrens;

   /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="childrens")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;
    
    /**
     * Constructor
     *
     * ArrayCollection
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Categorie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Add childrens
     *
     * @param \LGDD\SiteBundle\Entity\Categorie $childrens
     * @return Categorie
     */
    public function addChildren(\LGDD\SiteBundle\Entity\Categorie $childrens)
    {
        $this->childrens[] = $childrens;

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \LGDD\SiteBundle\Entity\Categorie $childrens
     */
    public function removeChildren(\LGDD\SiteBundle\Entity\Categorie $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set parent
     *
     * @param \LGDD\SiteBundle\Entity\Categorie $parent
     * @return Categorie
     */
    public function setParent(\LGDD\SiteBundle\Entity\Categorie $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \LGDD\SiteBundle\Entity\Categorie 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add articles
     *
     * @param \LGDD\SiteBundle\Entity\Categorie $articles
     * @return Categorie
     */
    public function addArticle(\LGDD\SiteBundle\Entity\Categorie $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \LGDD\SiteBundle\Entity\Categorie $articles
     */
    public function removeArticle(\LGDD\SiteBundle\Entity\Categorie $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
