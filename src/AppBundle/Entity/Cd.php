<?php

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cd
 *
 * @ORM\Table(name="f_cd",indexes={@ORM\Index(name="artiste", columns={"artiste"}), @ORM\Index(name="genre", columns={"genre"}), @ORM\Index(name="support", columns={"support"}), @ORM\Index(name="type", columns={"type"}), @ORM\Index(name="airplay", columns={"cd", "airplay"}), @ORM\Index(name="dprogra", columns={"dprogra"}), @ORM\Index(name="jsaisie", columns={"jsaisie"}), @ORM\Index(name="alllabel", columns={"label", "maison", "distrib"}), @ORM\Index(name="jsaisie_anne", columns={"jsaisie", "annee"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Cd
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cd", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cd;

    /**
     * @var Artiste
     *
     * @ORM\ManyToOne(targetEntity="Artiste")
     * @ORM\JoinColumn(name="artiste", referencedColumnName="artiste")
     */
    protected $artiste;

    /**
     * @var Piste
     *
     * @ORM\OneToMany(targetEntity="Piste", mappedBy="cd")
     * @ORM\JoinColumn(name="cd", referencedColumnName="cd")
     * @ORM\OrderBy({"piste" = "ASC"})
     */
    protected $pistes = array();

    /**
     * @var CdComment
     *
     * @ORM\OneToMany(targetEntity="CdComment", mappedBy="cd")
     * @ORM\JoinColumn(name="cd", referencedColumnName="cd")
     * @ORM\OrderBy({"dbkey" = "DESC"})
     */
    protected $comments = array();

    /**
     * @var CdComment
     *
     * @ORM\OneToMany(targetEntity="CdNote", mappedBy="cd")
     * @ORM\JoinColumn(name="cd", referencedColumnName="cd")
     */
    protected $notes = array();

    /**
     * @var CdEmprunt
     *
     * @ORM\OneToMany(targetEntity="CdEmprunt", mappedBy="cd")
     * @ORM\JoinColumn(name="cd", referencedColumnName="cd")
     */
    protected $emprunts = array();

    /**
     * @ORM\ManyToMany(targetEntity="Genre")
     * @ORM\JoinTable(name="f_cd_genre",
     *      joinColumns={@ORM\JoinColumn(name="cd", referencedColumnName="cd")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre", referencedColumnName="genre")}
     *      )
     */
    protected $styles;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AirplayCd", mappedBy="cd")
     * @ORM\JoinColumn(name="cd", referencedColumnName="cd")
     */
    protected $airplays;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=250, nullable=false)
     */
    private $titre = '';

    /**
     * @var Label
     *
     * @ORM\ManyToOne(targetEntity="Label")
     * @ORM\JoinColumn(name="label", referencedColumnName="label")
     */
    private $label = null;

    /**
     * @var Label
     *
     * @ORM\ManyToOne(targetEntity="Label")
     * @ORM\JoinColumn(name="maison", referencedColumnName="label")
     */
    private $maison = null;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Label")
     * @ORM\JoinColumn(name="distrib", referencedColumnName="label")
     */
    private $distrib = null;

    /**
     * @var \DateTime
     *
     * @Assert\Type(type="\DateTime", message="La valeur {{ value }} n'est pas un type date valide.")
     * @ORM\Column(name="dsortie", type="date", nullable=false)
     */
    private $dsortie = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=4, nullable=false)
     */
    private $annee = '0000';

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @Assert\NotBlank(message="Le type de disque doit être renseigné.")
     * @ORM\JoinColumn(name="type", referencedColumnName="type")
     */
    private $type = null;

    /**
     * @var Support
     *
     * @ORM\ManyToOne(targetEntity="Support")
     * @ORM\JoinColumn(name="support", referencedColumnName="support")
     */
    private $support = null;

    /**
     * @var Genre
     *
     * @ORM\ManyToOne(targetEntity="Genre")
     * @ORM\JoinColumn(name="genre", referencedColumnName="genre")
     */
    private $genre = null;

    /**
     * @var Langue
     *
     * @ORM\ManyToOne(targetEntity="Langue")
     * @ORM\JoinColumn(name="langue", referencedColumnName="langue")
     */
    private $langue;

    /**
     * @var Rotation
     *
     * @ORM\ManyToOne(targetEntity="Rotation")
     * @ORM\JoinColumn(name="rotation", referencedColumnName="rotation")
     */
    private $rotation;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_progra", referencedColumnName="user")
     */
    private $userProgra = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="dprogra", type="integer", nullable=false)
     */
    private $dprogra = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=false)
     */
    private $comment = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dsaisie", type="date", nullable=false)
     */
    private $dsaisie = '0000-00-00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="dvd", type="boolean", nullable=false)
     */
    private $dvd = false;

    /**
     * @var float
     *
     * @ORM\Column(name="note_moy", type="float", precision=5, scale=2, nullable=false)
     */
    private $noteMoy = '0.00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="airplay", type="boolean", nullable=false)
     */
    private $airplay = false;

    /**
     * @var string
     *
     * @ORM\Column(name="retour_mail", type="string", length=100, nullable=false)
     */
    private $retourMail = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="retour_label", type="boolean", nullable=false)
     */
    private $retourLabel = false;

    /**
     * @var string
     *
     * @ORM\Column(name="retour_comment", type="text", nullable=false)
     */
    private $retourComment='';

    /**
     * @var boolean
     *
     * @ORM\Column(name="various", type="boolean", nullable=false)
     */
    private $various = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_piste", type="integer", nullable=false)
     */
    private $nbPiste = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rivendell", type="boolean", nullable=false)
     */
    private $rivendell = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etiquette", type="boolean", nullable=false)
     */
    private $etiquette = false;

    /**
     * @var string
     *
     * @ORM\Column(name="libartiste", type="string", length=100, nullable=false)
     */
    private $libartiste = '';

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=250, nullable=false)
     */
    private $libelle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="discid", type="string", length=10, nullable=false)
     */
    private $discid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ref_label", type="string", length=45, nullable=false)
     */
    private $refLabel = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="suppr", type="boolean", nullable=false)
     */
    private $suppr = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="retour_attendu", type="integer", nullable=false)
     */
    private $retourAttendu = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=15, nullable=false)
     */
    private $img = '';

    /**
     * @Assert\Image(
     *     maxSize = "1024k",
     *     maxSizeMessage = "La pochette ne peut pas dépasser 1Mo.",
     *     mimeTypes = {"image/jpeg", "image/png", "image/jpg", "image/gif"},
     *     mimeTypesMessage = "Ce type de format n'est pas accepté (png, jpeg, jpg ou gif uniquement)."
     * )
     */
    public $file = null;

    /**
     * @var string
     *
     * @Assert\Url()
     * @ORM\Column(name="ecoute", type="string")
     */
    private $ecoute = null;

    public function __construct() {
        $this->dsortie = new \DateTime();
        $this->dsaisie = new \DateTime();
        $this->annee = date('Y');
    }


    /**
     * Set artiste
     *
     * @param Artiste $artiste
     */
    public function setArtiste($artiste)
    {
        $this->artiste = $artiste;
    }

    /**
     * Get artiste
     *
     * @return Artiste
     */
    public function getArtiste()
    {
        return $this->artiste;
    }

    /**
     * Set pistes
     *
     * @param ArrayCollection $pistes
     */
    public function setPistes($pistes)
    {
        $this->pistes = $pistes;
    }

    /**
     * @return pistes dans rivendell sous la forme 1 / 2 / 3
     */
    public function getDescriptionPistesInRivendell()
    {
      $p = array();
      foreach ($this->pistes as $piste) {
        if ($piste->getRivendell() || $piste->getStar()) {
          $p[] = $piste->getPiste();
        }
      }
      sort($p);
      return join(' / ', $p);
    }

    /**
     * Get pistes
     *
     * @return ArrayCollection
     */
    public function getPistes()
    {
        return $this->pistes;
    }

    /**
     * Set comments
     *
     * @param ArrayCollection $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get comments
     *
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set notes
     *
     * @param ArrayCollection $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get emprunts
     *
     * @return ArrayCollection
     */
    public function getEmprunts()
    {
        return $this->emprunts;
    }

    /**
     * Set emprunts
     *
     * @param ArrayCollection $emprunts
     */
    public function setEmprunts($emprunts)
    {
        $this->emprunts = $emprunts;
    }

    /**
     * Get styles
     *
     * @return ArrayCollection
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Set styles
     *
     * @param ArrayCollection $styles
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;
    }

    /**
     * Get notes
     *
     * @return ArrayCollection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Cd
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
     * Set label
     *
     * @param Label $label
     * @return Cd
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return le label, sinon la maison de disques, sinon le distributeur
     */
    public function getLabelAAfficher()
    {
      if ($this->label != null) {
        return $this->label;
      } elseif ($this->maison != null) {
        return $this->maison;
      } elseif ($this->distrib != null) {
        return $this->distrib;
      }
    }

    /**
     * Get label
     * @return Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set maison
     *
     * @param Label $maison
     * @return Cd
     */
    public function setMaison($maison)
    {
        $this->maison = $maison;

        return $this;
    }

    /**
     * Get maison
     *
     * @return Label
     */
    public function getMaison()
    {
        return $this->maison;
    }

    /**
     * Set distrib
     *
     * @param integer $distrib
     * @return Cd
     */
    public function setDistrib($distrib)
    {
        $this->distrib = $distrib;

        return $this;
    }

    /**
     * Get distrib
     *
     * @return integer
     */
    public function getDistrib()
    {
        return $this->distrib;
    }

    /**
     * Set dsortie
     *
     * @param \DateTime $dsortie
     * @return Cd
     */
    public function setDsortie($dsortie)
    {
        $this->dsortie = $dsortie;

        return $this;
    }

    /**
     * Get dsortie
     *
     * @return \DateTime
     */
    public function getDsortie()
    {
        return $this->dsortie;
    }

    /**
     * Set annee
     *
     * @param string $annee
     * @return Cd
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set type
     *
     * @param Type $type
     * @return Cd
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set airplays
     *
     * @param ArrayCollection $airplays
     * @return Cd
     */
    public function setAirplays($airplays)
    {
        $this->airplays = $airplays;

        return $this;
    }

    /**
     * Get airplays
     *
     * @return ArrayCollection
     */
    public function getAirplays()
    {
        return $this->airplays;
    }

    /**
     * Set support
     *
     * @param integer $support
     * @return Cd
     */
    public function setSupport($support)
    {
        $this->support = $support;

        return $this;
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

    /**
     * Set genre
     *
     * @param integer $genre
     * @return Cd
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * Get genre
     *
     * @return integer
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set langue
     *
     * @param integer $langue
     * @return Cd
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
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

    /**
     * Set rotation
     *
     * @param integer $rotation
     * @return Cd
     */
    public function setRotation($rotation)
    {
        $this->rotation = $rotation;

        return $this;
    }

    /**
     * Get rotation
     *
     * @return integer
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * Set userProgra
     *
     * @param integer $userProgra
     * @return Cd
     */
    public function setUserProgra($userProgra)
    {
        $this->userProgra = $userProgra;

        return $this;
    }

    /**
     * Get userProgra
     *
     * @return integer
     */
    public function getUserProgra()
    {
        return $this->userProgra;
    }

    /**
     * Set dprogra
     *
     * @param integer $dprogra
     * @return Cd
     */
    public function setDprogra($dprogra)
    {
        $this->dprogra = $dprogra;

        return $this;
    }

    /**
     * Get dprogra
     *
     * @return integer
     */
    public function getDprogra()
    {
        return $this->dprogra;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Cd
     */
    public function setComment($comment)
    {
        if(empty($comment)) {$comment='';}
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set dsaisie
     *
     * @param \DateTime $dsaisie
     * @return Cd
     */
    public function setDsaisie($dsaisie)
    {
        $this->dsaisie = $dsaisie;

        return $this;
    }

    /**
     * Get dsaisie
     *
     * @return \DateTime
     */
    public function getDsaisie()
    {
        return $this->dsaisie;
    }

    /**
     * Set dvd
     *
     * @param boolean $dvd
     * @return Cd
     */
    public function setDvd($dvd)
    {
        $this->dvd = $dvd;

        return $this;
    }

    /**
     * Get dvd
     *
     * @return boolean
     */
    public function getDvd()
    {
        return $this->dvd;
    }

    /**
     * Set noteMoy
     *
     * @param float $noteMoy
     * @return Cd
     */
    public function setNoteMoy($noteMoy)
    {
        $this->noteMoy = $noteMoy;

        return $this;
    }

    /**
     * Get noteMoy
     *
     * @return float
     */
    public function getNoteMoy()
    {
        return $this->noteMoy;
    }

    /**
     * Set airplay
     *
     * @param boolean $airplay
     * @return Cd
     */
    public function setAirplay($airplay)
    {
        $this->airplay = $airplay;

        return $this;
    }

    /**
     * Get airplay
     *
     * @return boolean
     */
    public function getAirplay()
    {
        return $this->airplay;
    }

    /**
     * Set retourMail
     *
     * @param string $retourMail
     * @return Cd
     */
    public function setRetourMail($retourMail)
    {
        $this->retourMail = $retourMail;

        return $this;
    }

    /**
     * Get retourMail
     *
     * @return string
     */
    public function getRetourMail()
    {
        return $this->retourMail;
    }

    /**
     * Set retourLabel
     *
     * @param boolean $retourLabel
     * @return Cd
     */
    public function setRetourLabel($retourLabel)
    {
        if(empty($retourLabel)) {$retourLabel='';}
        $this->retourLabel = $retourLabel;

        return $this;
    }

    /**
     * Get retourLabel
     *
     * @return boolean
     */
    public function getRetourLabel()
    {
        return $this->retourLabel;
    }

    /**
     * Set retourComment
     *
     * @param string $retourComment
     * @return Cd
     */
    public function setRetourComment($retourComment)
    {
        if(empty($retourComment)) {$retourComment='';}
        $this->retourComment = $retourComment;

        return $this;
    }

    /**
     * Get retourComment
     *
     * @return string
     */
    public function getRetourComment()
    {
        return $this->retourComment;
    }

    /**
     * Set various
     *
     * @param boolean $various
     * @return Cd
     */
    public function setVarious($various)
    {
        $this->various = $various;

        return $this;
    }

    /**
     * Get various
     *
     * @return boolean
     */
    public function getVarious()
    {
        return $this->various;
    }

    /**
     * Set nbPiste
     *
     * @param integer $nbPiste
     * @return Cd
     */
    public function setNbPiste($nbPiste)
    {
        $this->nbPiste = $nbPiste;

        return $this;
    }

    /**
     * Get nbPiste
     *
     * @return integer
     */
    public function getNbPiste()
    {
        return $this->nbPiste;
    }

    /**
     * Set rivendell
     *
     * @param boolean $rivendell
     * @return Cd
     */
    public function setRivendell($rivendell)
    {
        $this->rivendell = $rivendell;

        return $this;
    }

    /**
     * Get rivendell
     *
     * @return boolean
     */
    public function getRivendell()
    {
        return $this->rivendell;
    }

    /**
     * Set etiquette
     *
     * @param boolean $etiquette
     * @return Cd
     */
    public function setEtiquette($etiquette)
    {
        $this->etiquette = $etiquette;

        return $this;
    }

    /**
     * Get etiquette
     *
     * @return boolean
     */
    public function getEtiquette()
    {
        return $this->etiquette;
    }

    /**
     * Set libartiste
     *
     * @param string $libartiste
     * @return Cd
     */
    public function setLibartiste($libartiste)
    {
        $this->libartiste = $libartiste;

        return $this;
    }

    /**
     * Get libartiste
     *
     * @return string
     */
    public function getLibartiste()
    {
        return $this->libartiste;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Cd
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
     * Set discid
     *
     * @param string $discid
     * @return Cd
     */
    public function setDiscid($discid)
    {
        $this->discid = $discid;

        return $this;
    }

    /**
     * Get discid
     *
     * @return string
     */
    public function getDiscid()
    {
        return $this->discid;
    }

    /**
     * Set refLabel
     *
     * @param string $refLabel
     * @return Cd
     */
    public function setRefLabel($refLabel)
    {
        if(empty($refLabel)) {$refLabel='';}
        $this->refLabel = $refLabel;

        return $this;
    }

    /**
     * Get refLabel
     *
     * @return string
     */
    public function getRefLabel()
    {
        return $this->refLabel;
    }

    /**
     * Set suppr
     *
     * @param boolean $suppr
     * @return Cd
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
     * Set retourAttendu
     *
     * @param integer $retourAttendu
     * @return Cd
     */
    public function setRetourAttendu($retourAttendu)
    {
        $this->retourAttendu = $retourAttendu;

        return $this;
    }

    /**
     * Get retourAttendu
     *
     * @return integer
     */
    public function getRetourAttendu()
    {
        return $this->retourAttendu;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return Cd
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Get cd
     *
     * @return integer
     */
    public function getCd()
    {
        return $this->cd;
    }

    /**
     * Set ecoute
     *
     * @param integer $ecoute
     * @return AirplayCd
     */
    public function setEcoute($ecoute)
    {
        $this->ecoute = $ecoute;

        return $this;
    }

    /**
     * Get ecoute
     *
     * @return integer
     */
    public function getEcoute()
    {
        return $this->ecoute;
    }

    public function getCoverFilename()
    {
        return 'cd_'.$this->cd.$this->img;
    }

    public function getImgWebPath()
    {
        return empty($this->img) ? 'img/default_cd_cover.png' : 'img/cd/'.$this->getCoverFilename();
    }

    public function getAbsolutePath()
    {
        return empty($this->img) ? null : $this->getUploadRootDir().DIRECTORY_SEPARATOR.$this->getCoverFilename();
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.DIRECTORY_SEPARATOR.AppBundle::getUploadRootDir().DIRECTORY_SEPARATOR.join(DIRECTORY_SEPARATOR, array('img', 'cd'));
    }

    private $toBeRemoved = null;

    /**
     * Si CdType a mis un upload dans $file, alors on doit enregistrer l'extension dans 'img'
     * en passant cela forcera Doctrine a enregistrer l'entité et donc a appeler ensuite la callback 'upload()'
     *
     * on couvre aussi le cas où on upload une nouvelle image, mais avec la même extension:
     * dans ce cas on ajoute un _ pour être sur que l'entité sera mise à jour (et donc, que upload() sera appelée)
     * du coup, en cas de mise à jour de la cover le nouveau fichier n'a jamais le même chemin que l'ancien
     */
    public function prepareUpload()
    {
        if (null !== $this->file) {
            $current = $this->getImg();
            $this->toBeRemoved = $this->getAbsolutePath();

            $this->setImg('.'.$this->file->guessExtension());

            if ($current == $this->getImg()) {
                $this->setImg('_'.$current);
            }
        }
    }

    /**
     * L'éventuel fichier envoyé est enregistré dans cette callback, pour ne le faire que si l'enregistrement en DB s'est bien passé
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // en cas d'erreur, move lance une exception qui bloquera l'enregistrement
        $this->file->move($this->getUploadRootDir(), $this->getAbsolutePath());

        if ($this->toBeRemoved != null) {
            @unlink($this->toBeRemoved);
        }

        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeImg()
    {
        if ($file = $this->getAbsolutePath()) {
            $this->img = null;
            unlink($file);
        }
    }
}
