<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("sandwichesjson")]
    private ?string $name = null;

    /**
     * @var Collection<int, Sandwich>
     */
    #[ORM\ManyToMany(targetEntity: Sandwich::class, inversedBy: 'ingredients')]
    private Collection $sandwiches;

    public function __construct()
    {
        $this->sandwiches = new ArrayCollection();
    }


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

    /**
     * @return Collection<int, Sandwich>
     */
    public function getSandwiches(): Collection
    {
        return $this->sandwiches;
    }

    public function addSandwich(Sandwich $sandwich): static
    {
        if (!$this->sandwiches->contains($sandwich)) {
            $this->sandwiches->add($sandwich);
        }

        return $this;
    }

    public function removeSandwich(Sandwich $sandwich): static
    {
        $this->sandwiches->removeElement($sandwich);

        return $this;
    }


}
