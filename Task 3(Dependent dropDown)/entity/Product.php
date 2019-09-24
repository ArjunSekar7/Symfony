<?php

namespace App\Entity;

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
}
