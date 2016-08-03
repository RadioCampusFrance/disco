<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Support
 *
 * @ORM\Table(name="f_support", indexes={@ORM\Index(name="libelle", columns={"libelle"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SupportRepository")
 */
class Support
{
    /**
     * @var integer
     *
     * @ORM\Column(name="support", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $support;

    /**
     * @ORM\OneToMany(targetEntity="Cd", mappedBy="support")
     * @ORM\JoinColumn(name="support", referencedColumnName="support")
     */
    private $disques;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=45, nullable=false)
     */
    private $libelle = '';

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
     * @return Support
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
     * Get support
     *
     * @return integer
     */
    public function getSupport()
    {
        return $this->support;
    }
}
