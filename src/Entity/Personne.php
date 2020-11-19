<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity
 */
class Personne
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pers", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPers;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pers", type="string", length=255, nullable=false)
     */
    private $nomPers;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_pers", type="string", length=255, nullable=false)
     */
    private $prenomPers;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_naissance", type="date", nullable=true)
     */
    private $dataNaissance;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Appartement", inversedBy="idPers")
     * @ORM\JoinTable(name="person_appart",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_pers", referencedColumnName="id_pers")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_appart", referencedColumnName="id_appart")
     *   }
     * )
     */
    private $idAppart;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idAppart = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdPers(): ?int
    {
        return $this->idPers;
    }

    public function getNomPers(): ?string
    {
        return $this->nomPers;
    }

    public function setNomPers(string $nomPers): self
    {
        $this->nomPers = $nomPers;

        return $this;
    }

    public function getPrenomPers(): ?string
    {
        return $this->prenomPers;
    }

    public function setPrenomPers(string $prenomPers): self
    {
        $this->prenomPers = $prenomPers;

        return $this;
    }

    public function getDataNaissance(): ?\DateTimeInterface
    {
        return $this->dataNaissance;
    }

    public function setDataNaissance(?\DateTimeInterface $dataNaissance): self
    {
        $this->dataNaissance = $dataNaissance;

        return $this;
    }

    /**
     * @return Collection|Appartement[]
     */
    public function getIdAppart(): Collection
    {
        return $this->idAppart;
    }

    public function addIdAppart(Appartement $idAppart): self
    {
        if (!$this->idAppart->contains($idAppart)) {
            $this->idAppart[] = $idAppart;
        }

        return $this;
    }

    public function removeIdAppart(Appartement $idAppart): self
    {
        $this->idAppart->removeElement($idAppart);

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getNomPers()." ".$this->getPrenomPers();
    }
}
