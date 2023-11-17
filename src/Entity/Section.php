<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 100000)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: CompletedSections::class)]
    private Collection $completedSections;

    public function __construct()
    {
        $this->completedSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, CompletedSections>
     */
    public function getCompletedSections(): Collection
    {
        return $this->completedSections;
    }

    public function addCompletedSection(CompletedSections $completedSection): static
    {
        if (!$this->completedSections->contains($completedSection)) {
            $this->completedSections->add($completedSection);
            $completedSection->setSection($this);
        }

        return $this;
    }

    public function removeCompletedSection(CompletedSections $completedSection): static
    {
        if ($this->completedSections->removeElement($completedSection)) {
            // set the owning side to null (unless already changed)
            if ($completedSection->getSection() === $this) {
                $completedSection->setSection(null);
            }
        }

        return $this;
    }
}
