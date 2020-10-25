<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Criteria;

/**
 * Label
 *
 * @ORM\Table(name="f_label", indexes={@ORM\Index(name="libelle", columns={"libelle"})})
 * @UniqueEntity(fields="libelle", message=" Ce label existe déjà...")
 * @ORM\Entity
 */
class Label
{
    /**
     * @var integer
     *
     * @ORM\Column(name="label", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="Cd", mappedBy="label")
     * @ORM\JoinColumn(name="label", referencedColumnName="label")
     */
    private $disques = null;

    /**
     * @var string
     * @Assert\NotBlank(message="Le nom du label ne peut pas être vide")
     * @Assert\Length(
     *      min="1",
     *      max = "45",
     *      minMessage=" Le label doit disposer d'un nom assez long : {{ limit }} caractère minimum.",
     *      maxMessage=" Le nom du label est trop long : {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="libelle", type="string", length=45, nullable=false)
     */
    private $libelle = '';

    /**
     * @var string
     * @Assert\Length(
     *      min="4",
     *      max = "45",
     *      minMessage=" {{ limit }} caractères minimum.",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide, cela doit-être une adresse mail.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="telephone", type="string", length=45, nullable=false)
     */
    private $telephone = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="adresse", type="string", length=45, nullable=false)
     */
    private $adresse = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="adresse2", type="string", length=45, nullable=false)
     */
    private $adresse2 = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="cp", type="string", length=45, nullable=false)
     */
    private $cp = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="ville", type="string", length=45, nullable=false)
     */
    private $ville = '';

    /**
     * @var string
     * @Assert\Length(
     *      min="4",
     *      max = "250",
     *      minMessage=" {{ limit }} caractères minimum.",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide, cela doit-être une adresse mail.",
     *     checkMX = true
     * )
     * @ORM\Column(name="mail_progra", type="string", length=250)
     */
    private $mailProgra = null;

    /**
     * @var string
     * @Assert\Length(
     *      max = "150",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="contact1", type="string", length=150, nullable=false)
     */
    private $contact1 = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "150",
     *      maxMessage=" {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="siteweb", type="string", length=150, nullable=false)
     */
    private $siteweb = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="suppr", type="boolean", nullable=false)
     */
    private $suppr = false;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=false)
     */
    private $info = '';

    public function __construct() {
        $this->disques = new ArrayCollection();
    }


    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Label
     */
    public function setLibelle($libelle)
    {
        $this->libelle = strtoupper($libelle);

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
     * Set disques
     *
     * @param ArrayCollection $disques
     * @return Label
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
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('suppr', false));
        return $this->disques->matching($criteria);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Label
     */
    public function setEmail($email)
    {
        if(!$email) { $email = ""; }
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
     * Set telephone
     *
     * @param string $telephone
     * @return Label
     */
    public function setTelephone($telephone)
    {

        if(!$telephone) { $telephone = ""; }
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Label
     */
    public function setAdresse($adresse)
    {

        if(!$adresse) { $adresse = ""; }
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adresse2
     *
     * @param string $adresse2
     * @return Label
     */
    public function setAdresse2($adresse2)
    {

        if(!$adresse2) { $adresse2 = ""; }
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Get adresse2
     *
     * @return string
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return Label
     */
    public function setCp($cp)
    {

        if(!$cp) { $cp = ""; }
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Label
     */
    public function setVille($ville)
    {

        if(!$ville) { $ville = ""; }
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set mailProgra
     *
     * @param string $mailProgra
     * @return Label
     */
    public function setMailProgra($mailProgra)
    {
        if(!$mailProgra) { $mailProgra = ""; }
        $this->mailProgra = $mailProgra;

        return $this;
    }

    /**
     * Get mailProgra
     *
     * @return string
     */
    public function getMailProgra()
    {
        return $this->mailProgra;
    }

    /**
     * Set contact1
     *
     * @param string $contact1
     * @return Label
     */
    public function setContact1($contact1)
    {
        if(!$contact1) { $contact1 = ""; }
        $this->contact1 = $contact1;

        return $this;
    }

    /**
     * Get contact1
     *
     * @return string
     */
    public function getContact1()
    {
        return $this->contact1;
    }

    /**
     * Set siteweb
     *
     * @param string $siteweb
     * @return Label
     */
    public function setSiteweb($siteweb)
    {
        if(!$siteweb) { $siteweb = ""; }
        $this->siteweb = $siteweb;

        return $this;
    }

    /**
     * Get siteweb
     *
     * @return string
     */
    public function getSiteweb()
    {
        return $this->siteweb;
    }

    /**
     * Set suppr
     *
     * @param boolean $suppr
     * @return Label
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
     * Set info
     *
     * @param string $info
     * @return Label
     */
    public function setInfo($info)
    {
        if(!$info) { $info = ""; }
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Get label
     *
     * @return integer
     */
    public function getLabel()
    {
        return $this->label;
    }
}
