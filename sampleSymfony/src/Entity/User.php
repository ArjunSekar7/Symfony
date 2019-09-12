<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */

    

    private $mail_id;

    /**
     * @ORM\Column(type="string", length=20)
     */

    private $password;

    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMailId(): ?string
    {
        return $this->mail_id;
    }

    public function setMailId(string $mail_id): self
    {
        $this->mail_id = $mail_id;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
