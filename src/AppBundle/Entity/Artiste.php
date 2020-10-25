<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Criteria;

/**
 * Artiste
 *
 * @ORM\Table(name="f_artiste", uniqueConstraints={@ORM\UniqueConstraint(name="artiste", columns={"artiste"})}, indexes={@ORM\Index(name="libelle", columns={"libelle"})})
 * @ORM\Entity
 * @UniqueEntity(fields="libelle", message=" Cet artiste existe déjà...")
 */
class Artiste
{
    /**
     * @var integer
     *
     * @ORM\Column(name="artiste", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $artiste = '0';

    /**
     * @ORM\OneToMany(targetEntity="Cd", mappedBy="artiste")
     * @ORM\JoinColumn(name="artiste", referencedColumnName="artiste")
     */
    private $disques;

    /**
     * @var string
     * @Assert\NotBlank(message="Le nom de l'artiste ne peut pas être vide")
     * @Assert\Length(
     *      min="1",
     *      max = "255",
     *      minMessage=" L'artiste doit disposer d'un nom assez long : {{ limit }} caractère minimum.",
     *      maxMessage=" Le nom de l'artiste est trop long : {{ limit }} caractères maximum."
     * )
     * @ORM\Column(name="libelle", type="string", length=300, nullable=false)
     */
    private $libelle = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "150",
     *      maxMessage=" L'adresse du site web ne doit pas être trop longue : {{ limit }} caractères maximum. Si cela dépasse, utilisez un service de réduction d'URL !"
     * )
     * @ORM\Column(name="siteweb", type="string", length=150, nullable=false)
     */
    private $siteweb = '';

    /**
     * @var string
     * @Assert\Length(
     *      max = "150",
     *      maxMessage=" L'adresse du site d'écoute ne doit pas être trop longue : {{ limit }} caractères maximum. Si cela dépasse, utilisez un service de réduction d'URL !"
     * )
     * @ORM\Column(name="myspace", type="string", length=150, nullable=false)
     */
    private $myspace = '';

    /**
     * Set Disques
     * @param ArrayCollection $disques
     */
    public function setDisques($disques) {
        $this->disques = $disques;
    }

    /**
     * Get Disques
     * @return ArrayCollection
     */
    public function getDisques() {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('suppr', false));
        return $this->disques->matching($criteria);
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Artiste
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
     * Set siteweb
     *
     * @param string $siteweb
     * @return Artiste
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
     * Set myspace
     *
     * @param string $myspace
     * @return Artiste
     */
    public function setMyspace($myspace)
    {
        if(!$myspace) { $myspace = ""; }
        $this->myspace = $myspace;

        return $this;
    }

    /**
     * Get myspace
     *
     * @return string
     */
    public function getMyspace()
    {
        return $this->myspace;
    }

    /**
     * Get artiste
     *
     * @return integer
     */
    public function getArtiste()
    {
        return $this->artiste;
    }

    /**
     * @return siteweb ou mySpace ou null
     */
    public function getUrl()
    {
      if (!empty($this->siteweb)) {
        return $this->siteweb;
      } elseif ($this->myspace) {
        return $this->myspace;
      } else {
        return null;
      }
    }
}
