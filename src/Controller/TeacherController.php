<?php 
namespace App\Controller;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher/courses', name: 'teacher_courses')]
    public function enrollments(): Response
    {
        $user = $this->getUser();
        $courses = $user->getCourses();

        return $this->render('teacher/courses.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/teacher/courses/{id}', name: 'manage_course')]
    public function manageCourse(Course $course): Response
    {
        return $this->render('teacher/manage_course.html.twig', [
            'course' => $course,
            'sections' => $course->getSections(),
            'enrollments' => $course->getEnrollments()
        ]);
    }
}