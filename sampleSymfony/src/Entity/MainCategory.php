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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="main_category")
     */
    private $Product;


    public function __construct()
    {
        $this->sub_category_name = new ArrayCollection();
        $this->Product = new ArrayCollection();
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

    public function addSubCategoryName(SubCategory $subCategoryName)
    {
        $subCategoryName->setMainCategory($this);
        $this->sub_category_name->add($subCategoryName);
    }

    public function removeSubCategoryName(SubCategory $subCategoryName)
    {
        $this->sub_category_name->removeElement($subCategoryName);
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->Product;
    }

    public function addProduct(Product $product)
    {
        $product->setMainCategory($this);
        $this->Product->add($product);
    }

    public function removeProduct(Product $product)
    {
        $this->Product->removeElement($product);
    }

}
