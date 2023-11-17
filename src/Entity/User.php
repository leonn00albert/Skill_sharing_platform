<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Course::class)]
    private Collection $courses;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Enrollment::class)]
    private Collection $enrollments;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: CompletedSections::class)]
    private Collection $completedSections;


    public function __construct()
    {
        $this->enrollments = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->completedSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Enrollment>
     */

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setTeacher($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getTeacher() === $this) {
                $course->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Enrollment>
     */
    public function getEnrollments(): Collection
    {
        return $this->enrollments;
    }

    public function addEnrollment(Enrollment $enrollment): static
    {
        if (!$this->enrollments->contains($enrollment)) {
            $this->enrollments->add($enrollment);
            $enrollment->setStudent($this);
        }

        return $this;
    }

    public function removeEnrollment(Enrollment $enrollment): static
    {
        if ($this->enrollments->removeElement($enrollment)) {
            // set the owning side to null (unless already changed)
            if ($enrollment->getStudent() === $this) {
                $enrollment->setStudent(null);
            }
        }

        return $this;
    }
    public function isEnrolled(Course $course): bool
    {
        $contains = false;
        foreach ($this->enrollments as $enrollment) {
            if ($enrollment->getCourse()->getId() == $course->getId()) {
                $contains = true;
            }
        }
        return $contains;
    }
    public function hasCompleted(Section $section): bool
    {
        $completed = false;
        foreach ($this->getCompletedSections() as $completed_section) {
            if ($completed_section->getSection()->getId() == $section->getId()) {
                $completed = true;
            }
        }
        return $completed;
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
            $completedSection->setStudent($this);
        }

        return $this;
    }

    public function removeCompletedSection(CompletedSections $completedSection): static
    {
        if ($this->completedSections->removeElement($completedSection)) {
            if ($completedSection->getStudent() === $this) {
                $completedSection->setStudent(null);
            }
        }

        return $this;
    }
}
