<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Appartement
 *
 * @ORM\Table(name="appartement", indexes={@ORM\Index(name="id_resi", columns={"id_resi"})})
 * @ORM\Entity
 */
class Appartement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_appart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAppart;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_appart", type="integer", nullable=false)
     */
    private $numeroAppart;

    /**
     * @var int
     *
     * @ORM\Column(name="surface_appart", type="integer", nullable=false)
     */
    private $surfaceAppart;

    /**
     * @var int
     *
     * @ORM\Column(name="etage", type="integer", nullable=false)
     */
    private $etage;

    /**
     * @var \Residence
     *
     * @ORM\ManyToOne(targetEntity="Residence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_resi", referencedColumnName="id_resi")
     * })
     */
    private $idResi;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Personne", mappedBy="idAppart")
     */
    private $idPers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdAppart(): ?int
    {
        return $this->idAppart;
    }

    public function getNumeroAppart(): ?int
    {
        return $this->numeroAppart;
    }

    public function setNumeroAppart(int $numeroAppart): self
    {
        $this->numeroAppart = $numeroAppart;

        return $this;
    }

    public function getSurfaceAppart(): ?int
    {
        return $this->surfaceAppart;
    }

    public function setSurfaceAppart(int $surfaceAppart): self
    {
        $this->surfaceAppart = $surfaceAppart;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getIdResi(): ?Residence
    {
        return $this->idResi;
    }

    public function setIdResi(?Residence $idResi): self
    {
        $this->idResi = $idResi;

        return $this;
    }

    /**
     * @return Collection|Personne[]
     */
    public function getIdPers(): Collection
    {
        return $this->idPers;
    }

    public function addIdPer(Personne $idPer): self
    {
        if (!$this->idPers->contains($idPer)) {
            $this->idPers[] = $idPer;
            $idPer->addIdAppart($this);
        }

        return $this;
    }

    public function removeIdPer(Personne $idPer): self
    {
        if ($this->idPers->removeElement($idPer)) {
            $idPer->removeIdAppart($this);
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getNumeroAppart();
    }

}
