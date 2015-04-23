<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Airplay
 *
 * @ORM\Table(name="f_airplay")
 * @ORM\Entity
 */
class Airplay
{
    /**
     * @var integer
     *
     * @ORM\Column(name="airplay", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $airplay;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=200, nullable=false)
     */
    private $libelle = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dcreat", type="datetime", nullable=false)
     */
    private $dcreat = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer", nullable=false)
     */
    private $annee = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mois", type="integer", nullable=false)
     */
    private $mois = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dmodif", type="datetime", nullable=false)
     */
    private $dmodif = '0000-00-00 00:00:00';

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="mUser", referencedColumnName="user")
     */
    private $cUser = '0';

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="mUser", referencedColumnName="user")
     */
    private $mUser = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="publie", type="boolean", nullable=false)
     */
    private $publie = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="chrono", type="datetime", nullable=false)
     */
    private $chrono = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="courant", type="boolean", nullable=false)
     */
    private $courant = '0';



    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Airplay
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
     * Set dcreat
     *
     * @param \DateTime $dcreat
     * @return Airplay
     */
    public function setDcreat($dcreat)
    {
        $this->dcreat = $dcreat;

        return $this;
    }

    /**
     * Get dcreat
     *
     * @return \DateTime 
     */
    public function getDcreat()
    {
        return $this->dcreat;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return Airplay
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     * @return Airplay
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return integer 
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set dmodif
     *
     * @param \DateTime $dmodif
     * @return Airplay
     */
    public function setDmodif($dmodif)
    {
        $this->dmodif = $dmodif;

        return $this;
    }

    /**
     * Get dmodif
     *
     * @return \DateTime 
     */
    public function getDmodif()
    {
        return $this->dmodif;
    }

    /**
     * Set cUser
     *
     * @param User $cUser
     * @return Airplay
     */
    public function setCUser($cUser)
    {
        $this->cUser = $cUser;

        return $this;
    }

    /**
     * Get cUser
     *
     * @return User 
     */
    public function getCUser()
    {
        return $this->cUser;
    }

    /**
     * Set mUser
     *
     * @param User $mUser
     * @return Airplay
     */
    public function setMUser($mUser)
    {
        $this->mUser = $mUser;

        return $this;
    }

    /**
     * Get mUser
     *
     * @return User 
     */
    public function getMUser()
    {
        return $this->mUser;
    }

    /**
     * Set publie
     *
     * @param boolean $publie
     * @return Airplay
     */
    public function setPublie($publie)
    {
        $this->publie = $publie;

        return $this;
    }

    /**
     * Get publie
     *
     * @return boolean 
     */
    public function getPublie()
    {
        return $this->publie;
    }

    /**
     * Set chrono
     *
     * @param \DateTime $chrono
     * @return Airplay
     */
    public function setChrono($chrono)
    {
        $this->chrono = $chrono;

        return $this;
    }

    /**
     * Get chrono
     *
     * @return \DateTime 
     */
    public function getChrono()
    {
        return $this->chrono;
    }

    /**
     * Set courant
     *
     * @param boolean $courant
     * @return Airplay
     */
    public function setCourant($courant)
    {
        $this->courant = $courant;

        return $this;
    }

    /**
     * Get courant
     *
     * @return boolean 
     */
    public function getCourant()
    {
        return $this->courant;
    }

    /**
     * Get airplay
     *
     * @return integer 
     */
    public function getAirplay()
    {
        return $this->airplay;
    }
}