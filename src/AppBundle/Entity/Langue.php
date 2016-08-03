<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Langue
 *
 * @ORM\Table(name="f_langue", uniqueConstraints={@ORM\UniqueConstraint(name="langue", columns={"langue"})}, indexes={@ORM\Index(name="libelle", columns={"libelle"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LangueRepository")
 */
class Langue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="langue", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $langue;

    /**
     * @ORM\OneToMany(targetEntity="Cd", mappedBy="langue")
     * @ORM\JoinColumn(name="langue", referencedColumnName="langue")
     */
    private $disques;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=45, nullable=false)
     */
    private $libelle = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif = '0';

    /**
     * Set disques
     *
     * @param ArrayCollection $disques
     * @return Type
     */
    public function setDisques($disques)
    {
        $this->disques = $disques;

        return $this;
    }

    /**
     * Get disques
     *
     * @return ArrayCollection
     */
    public function getDisques()
    {
        return $this->disques;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Langue
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Langue
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Get langue
     *
     * @return integer
     */
    public function getLangue()
    {
        return $this->langue;
    }
}
