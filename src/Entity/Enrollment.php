<?php

namespace App\Entity;

use App\Repository\EnrollmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnrollmentRepository::class)]
class Enrollment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enrollments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $student = null;

    #[ORM\ManyToOne(inversedBy: 'enrollments')]
    private ?Course $course = null;

    #[ORM\Column]
    private ?int $section_count = null;

    #[ORM\Column]
    private ?int $sections_completed = null;

    #[ORM\Column(length: 255)]
    private ?string $progress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): static
    {
        $this->student = $student;

        return $this;
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

    public function getSectionCount(): ?int
    {
        return $this->section_count;
    }

    public function setSectionCount(int $section_count): static
    {
        $this->section_count = $section_count;

        return $this;
    }

    public function getSectionsCompleted(): ?int
    {
        return $this->sections_completed;
    }

    public function setSectionsCompleted(int $sections_completed): static
    {
        $this->sections_completed = $sections_completed;

        return $this;
    }

    public function getProgress(): ?float
    {
        $courseSections = $this->course->getSections();
        $student = $this->getStudent();
        $completedCount = 0;
        foreach ($courseSections as $section) {
            if ($student->hasCompleted($section)) {
                $completedCount++;
            }
        }
        $totalSections = count($courseSections);
        if ($totalSections === 0) {
            return 0.0;
        }
        $progress = ($completedCount / $totalSections) * 100.0;
    
        return round($progress, 2);
    }

    public function sections_count(): ?float
    {
        $courseSections = $this->course->getSections();
        return count($courseSections);
    }
    public function completed_sections_count(): ?float
    {
        $courseSections = $this->course->getSections();
        $student = $this->getStudent();
        $completedCount = 0;
        return count($courseSections);  
        foreach ($courseSections as $section) {
            if ($student->hasCompleted($section)) {
                $completedCount++;
            }
        }
        return $completedCount;
    }

    public function completed_enrollment(): bool
    {
        if($this->completed_sections_count() == $this->sections_count()) {
            return true;
        } else {
            return false;
        }
    }

    public function setProgress(string $progress): static
    {
        $this->progress = $progress;

        return $this;
    }
}
