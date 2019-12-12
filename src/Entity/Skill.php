<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
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
    private $skill;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", mappedBy="userSkills")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkill(): ?string
    {
        return $this->skill;
    }

    public function setSkill(string $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Skill $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->addUserSkill($this);
        }

        return $this;
    }

    public function removeUser(Skill $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            $user->removeUserSkill($this);
        }

        return $this;
    }

}
