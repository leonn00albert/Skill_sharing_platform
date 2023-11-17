<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Enrollment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class EnrollmentController extends AbstractController
{
    #[Route('/enrollment', name: 'app_enrollment')]
    public function index(): Response
    {
        return $this->render('enrollment/index.html.twig', [
            'controller_name' => 'EnrollmentController',
        ]);
    }

        /**
     * @Route("/courses", name="course_list")
     */
    public function listCourses(EntityManagerInterface $entityManager)
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        return $this->render('enrollment/course_list.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/enroll/{courseId}", name="enroll_course")
     */
    public function enrollCourse(Request $request,EntityManagerInterface $entityManager, $courseId)
    {
        $user = $this->getUser(); 

        if (!$user) {
         
        }

        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
    
        }

        $enrollment = new Enrollment();
        $enrollment->setStudent($user);
        $enrollment->setCourse($course);
        $enrollment->setSectionCount($course->getSectionCount());
        $enrollment->setSectionsCompleted(0);
        $enrollment->setProgress(0);
        $entityManager->persist($enrollment);
        $entityManager->flush();

        $this->addFlash('success', 'Enrollment successful');

        return $this->redirectToRoute('course_list');
    }
}
