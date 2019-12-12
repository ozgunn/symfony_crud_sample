<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=20)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $level;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="user")
     */
    private $userSkills;

    public function __construct()
    {
        $this->userSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getUserSkills(): Collection
    {
        return $this->userSkills;
    }

    public function addUserSkill(Skill $userSkill): self
    {
        if (!$this->userSkills->contains($userSkill)) {
            $this->userSkills[] = $userSkill;
        }

        return $this;
    }

    public function removeUserSkill(Skill $userSkill): self
    {
        if ($this->userSkills->contains($userSkill)) {
            $this->userSkills->removeElement($userSkill);
        }

        return $this;
    }

}
