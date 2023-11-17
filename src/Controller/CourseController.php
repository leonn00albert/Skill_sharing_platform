<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/course', name: 'app_course')]
    public function index(): Response
    {
        return $this->render('course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }
    /**
     * @Route("/course/new", name="course_new")
     */

    /**
     * @Route("/courses", name="courses_list")
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        return $this->render('course/list.html.twig', [
            'courses' => $courses,
        ]);
    }
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser(); 

        if (!$user) {
         
        }

        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course->setTeacher($user);
            $entityManager->persist($course);
            $entityManager->flush();

            $this->addFlash('success', 'Course created successfully');

            return $this->redirectToRoute('/teacher/courses');
        }

        return $this->render('course/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/course/{id}", name="course_view")
     */
    public function view(Course $course)
    {
        $sections = $course->getSections();

        return $this->render('course/view.html.twig', [
            'course' => $course,
            'sections' => $sections,
        ]);
    }

    public function edit(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Course updated successfully.');

            return $this->redirectToRoute('teacher_courses');
        }

        return $this->render('course/edit.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
        ]);
    }

    public function delete($id , EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }
        $entityManager->remove($course);
        $entityManager->flush();

        $this->addFlash('success', 'Course deleted successfully.');

        return $this->redirectToRoute('teacher_courses');
    }
}
