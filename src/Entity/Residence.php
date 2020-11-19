<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Residence
 *
 * @ORM\Table(name="residence")
 * @ORM\Entity
 */
class Residence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_resi", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResi;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_resi", type="string", length=255, nullable=false)
     */
    private $nomResi;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_resi", type="string", length=255, nullable=false)
     */
    private $adresseResi;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_appart", type="integer", nullable=false)
     */
    private $nombreAppart;

    public function getIdResi(): ?int
    {
        return $this->idResi;
    }

    public function getNomResi(): ?string
    {
        return $this->nomResi;
    }

    public function setNomResi(string $nomResi): self
    {
        $this->nomResi = $nomResi;

        return $this;
    }

    public function getAdresseResi(): ?string
    {
        return $this->adresseResi;
    }

    public function setAdresseResi(string $adresseResi): self
    {
        $this->adresseResi = $adresseResi;

        return $this;
    }

    public function getNombreAppart(): ?int
    {
        return $this->nombreAppart;
    }

    public function setNombreAppart(int $nombreAppart): self
    {
        $this->nombreAppart = $nombreAppart;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getNomResi();
    }
}
