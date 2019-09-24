<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainCategoryRepository")
 */
class MainCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubCategory", mappedBy="mainCategory", orphanRemoval=true)
     */
    private $sub_category_name;

    public function __construct()
    {
        $this->sub_category_name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|SubCategory[]
     */
    public function getSubCategoryName(): Collection
    {
        return $this->sub_category_name;
    }

    public function addSubCategoryName(SubCategory $subCategoryName): self
    {
        if (!$this->sub_category_name->contains($subCategoryName)) {
            $this->sub_category_name[] = $subCategoryName;
            $subCategoryName->setMainCategory($this);
        }

        return $this;
    }

    public function removeSubCategoryName(SubCategory $subCategoryName): self
    {
        if ($this->sub_category_name->contains($subCategoryName)) {
            $this->sub_category_name->removeElement($subCategoryName);
            // set the owning side to null (unless already changed)
            if ($subCategoryName->getMainCategory() === $this) {
                $subCategoryName->setMainCategory(null);
            }
        }

        return $this;
    }
}
