<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Projects", mappedBy="employee")
     */
    private $project_name;

    public function __construct()
    {
        $this->project_name = new ArrayCollection();
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
     * @return Collection|Projects[]
     */
    public function getProjectName(): Collection
    {
        return $this->project_name;
    }

    public function addProjectName(Projects $projectName): self
    {
        if (!$this->project_name->contains($projectName)) {
            $this->project_name[] = $projectName;
            $projectName->addEmployee($this);
        }

        return $this;
    }

    public function removeProjectName(Projects $projectName): self
    {
        if ($this->project_name->contains($projectName)) {
            $this->project_name->removeElement($projectName);
            $projectName->removeEmployee($this);
        }

        return $this;
    }

    public function __toString() {
        return (string)$this->id;
    }
}
