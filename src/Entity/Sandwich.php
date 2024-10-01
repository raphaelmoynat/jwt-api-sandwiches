<?php

namespace App\Entity;

use App\Repository\SandwichRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SandwichRepository::class)]
class Sandwich
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("sandwichesjson")]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("sandwichesjson")]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups("sandwichesjson")]
    private ?float $price = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'sandwiches', cascade: ['persist'])]
    #[Groups("sandwichesjson")]
    private Collection $ingredients;

    #[ORM\ManyToOne(inversedBy: 'sandwiches')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("sandwichesjson")]
    private ?User $author = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @var Collection<int, Ingredient>
     */


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }



    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->addSandwich($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeSandwich($this);
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }


}
