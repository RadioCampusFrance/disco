<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="f_user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Cd", mappedBy="userProgra")
     * @ORM\JoinColumn(name="user", referencedColumnName="user_progra")
     */
    private $disquesManipules;

    /**
     * @var boolean
     *
     * @ORM\Column(name="suppr", type="boolean", nullable=false)
     */
    private $suppr = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="inactif", type="boolean", nullable=false)
     */
    private $inactif = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=200, nullable=false)
     */
    private $nom = '';

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=200, nullable=false)
     */
    private $prenom = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="cotisation", type="boolean", nullable=false)
     */
    private $cotisation = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="groupe", type="string", length=45, nullable=false)
     */
    private $groupe = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="emission", type="string", length=200, nullable=false)
     */
    private $emission = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=400, nullable=false)
     */
    private $libelle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=20, nullable=false)
     */
    private $pwd = '';

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=false)
     */
    private $login = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="alerte_progra", type="boolean", nullable=false)
     */
    private $alerteProgra = '0';

    /**
     * Set disquesManipules
     *
     * @param ArrayCollection $disquesManipules
     * @return Type
     */
    public function setDisquesmanipules($disquesManipules)
    {
        $this->disquesManipules = $disquesManipules;

        return $this;
    }

    /**
     * Get disquesManipules
     *
     * @return ArrayCollection 
     */
    public function getDisquesmanipules()
    {
        return $this->disquesManipules;
    }

    /**
     * Set suppr
     *
     * @param boolean $suppr
     * @return User
     */
    public function setSuppr($suppr)
    {
        $this->suppr = $suppr;

        return $this;
    }

    /**
     * Get suppr
     *
     * @return boolean 
     */
    public function getSuppr()
    {
        return $this->suppr;
    }

    /**
     * Set inactif
     *
     * @param boolean $inactif
     * @return User
     */
    public function setInactif($inactif)
    {
        $this->inactif = $inactif;

        return $this;
    }

    /**
     * Get inactif
     *
     * @return boolean 
     */
    public function getInactif()
    {
        return $this->inactif;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set cotisation
     *
     * @param boolean $cotisation
     * @return User
     */
    public function setCotisation($cotisation)
    {
        $this->cotisation = $cotisation;

        return $this;
    }

    /**
     * Get cotisation
     *
     * @return boolean 
     */
    public function getCotisation()
    {
        return $this->cotisation;
    }

    /**
     * Set groupe
     *
     * @param string $groupe
     * @return User
     */
    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return string 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set emission
     *
     * @param string $emission
     * @return User
     */
    public function setEmission($emission)
    {
        $this->emission = $emission;

        return $this;
    }

    /**
     * Get emission
     *
     * @return string 
     */
    public function getEmission()
    {
        return $this->emission;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return User
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
     * Set pwd
     *
     * @param string $pwd
     * @return User
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Get pwd
     *
     * @return string 
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set alerteProgra
     *
     * @param boolean $alerteProgra
     * @return User
     */
    public function setAlerteProgra($alerteProgra)
    {
        $this->alerteProgra = $alerteProgra;

        return $this;
    }

    /**
     * Get alerteProgra
     *
     * @return boolean 
     */
    public function getAlerteProgra()
    {
        return $this->alerteProgra;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }
}
