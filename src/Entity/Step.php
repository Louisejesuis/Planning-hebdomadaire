<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: StepCategory::class, inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private $step_category;

    #[ORM\OneToMany(mappedBy: 'step', targetEntity: UserSteps::class)]
    private $userSteps;

    public function __construct()
    {
        $this->userSteps = new ArrayCollection();
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

    public function getStepCategory(): ?StepCategory
    {
        return $this->step_category;
    }

    public function setStepCategory(?StepCategory $step_category): self
    {
        $this->step_category = $step_category;

        return $this;
    }

    /**
     * @return Collection<int, UserSteps>
     */
    public function getUserSteps(): Collection
    {
        return $this->userSteps;
    }

    public function addUserStep(UserSteps $userStep): self
    {
        if (!$this->userSteps->contains($userStep)) {
            $this->userSteps[] = $userStep;
            $userStep->setStep($this);
        }

        return $this;
    }

    public function removeUserStep(UserSteps $userStep): self
    {
        if ($this->userSteps->removeElement($userStep)) {
            // set the owning side to null (unless already changed)
            if ($userStep->getStep() === $this) {
                $userStep->setStep(null);
            }
        }

        return $this;
    }
}
