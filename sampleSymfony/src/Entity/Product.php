<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubCategory", inversedBy="product_name")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sub_category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MainCategory", inversedBy="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $main_category;

  
    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->Product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->sub_category;
    }

    public function setSubCategory(?SubCategory $sub_category): self
    {
        $this->sub_category = $sub_category;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getMainCategory(): ?MainCategory
    {
        return $this->main_category;
    }

    public function setMainCategory(?MainCategory $main_category): self
    {
        $this->main_category = $main_category;

        return $this;
    }


}
