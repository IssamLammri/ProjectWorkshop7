<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataImgPer
 *
 * @ORM\Table(name="data_img_per", indexes={@ORM\Index(name="id_per", columns={"id_per"})})
 * @ORM\Entity
 */
class DataImgPer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="data", type="text", length=65535, nullable=true)
     */
    private $data;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_per", referencedColumnName="id_pers")
     * })
     */
    private $idPer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getIdPer(): ?Personne
    {
        return $this->idPer;
    }

    public function setIdPer(?Personne $idPer): self
    {
        $this->idPer = $idPer;

        return $this;
    }


}
