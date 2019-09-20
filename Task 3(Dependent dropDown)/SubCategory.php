<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubCategoryRepository")
 */
class SubCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MainCategory", inversedBy="sub_category_name")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="sub_category", orphanRemoval=true)
     */
    private $product_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sub_category_name;

    public function __construct()
    {
        $this->product_name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainCategory(): ?MainCategory
    {
        return $this->mainCategory;
    }

    public function setMainCategory(?MainCategory $mainCategory): self
    {
        $this->mainCategory = $mainCategory;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProductName(): Collection
    {
        return $this->product_name;
    }

    public function addProductName(Product $productName): self
    {
        if (!$this->product_name->contains($productName)) {
            $this->product_name[] = $productName;
            $productName->setSubCategory($this);
        }

        return $this;
    }

    public function removeProductName(Product $productName): self
    {
        if ($this->product_name->contains($productName)) {
            $this->product_name->removeElement($productName);
            // set the owning side to null (unless already changed)
            if ($productName->getSubCategory() === $this) {
                $productName->setSubCategory(null);
            }
        }

        return $this;
    }

    public function getSubCategoryName(): ?string
    {
        return $this->sub_category_name;
    }

    public function setSubCategoryName(string $sub_category_name): self
    {
        $this->sub_category_name = $sub_category_name;

        return $this;
    }
}
