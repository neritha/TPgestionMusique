<?php

namespace App\Entity;

// use Assert\Length;
// use Assert\NotBlank;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NationaliteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

// use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NationaliteRepository::class)
 */
class Nationalite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @NotBlank(message="Le libelle est obligatoire!")
     * @NotNull(message="Le libelle est obligatoire!")
     * @Length(
     *      min=3,
     *      minMessage="Le libelle doit comporter au minimum {{ limit }} caractères !",
     * )
     */

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  *  
    //  * @NotBlank(message="Le libellé ne peut pas être vide.")
    //  * @Assert\Length(
    //  * min = 2,
    //  * max = 255,
    //  * minMessage = "Le libellé doit comporter au moins {{ limit }} caractères",
    //  * maxMessage = "Le libellé ne peut pas dépasser {{ limit }} caractères"
    //  * )
    //  */

    
     private $libelle; 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $drapeau;

    /**
     * @ORM\OneToMany(targetEntity=Artiste::class, mappedBy="nationalite")
     */
    private $artistes;

    public function __construct()
    {
        $this->artistes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDrapeau(): ?string
    {
        return $this->drapeau;
    }

    public function setDrapeau(?string $drapeau): self
    {
        $this->drapeau = $drapeau;

        return $this;
    }

    /**
     * @return Collection<int, Artiste>
     */
    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(Artiste $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes[] = $artiste;
            $artiste->setNationalite($this);
        }

        return $this;
    }

    public function removeArtiste(Artiste $artiste): self
    {
        if ($this->artistes->removeElement($artiste)) {
            // set the owning side to null (unless already changed)
            if ($artiste->getNationalite() === $this) {
                $artiste->setNationalite(null);
            }
        }

        return $this;
    }
}
