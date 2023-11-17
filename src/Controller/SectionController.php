<?php

namespace App\Controller;

use App\Entity\CompletedSections;
use App\Entity\Section;
use App\Form\SectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    #[Route('/section', name: 'app_section')]
    public function index(): Response
    {
        return $this->render('section/index.html.twig', [
            'controller_name' => 'SectionController',
        ]);
    }

public function new(Request $request,EntityManagerInterface $entityManager)
{
    $section = new Section();
    $form = $this->createForm(SectionType::class, $section);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle section creation and association with a course here
        // Example: $section->setCourse($selectedCourse);

 
        $entityManager->persist($section);
        $entityManager->flush();

        $this->addFlash('success', 'Section created successfully');

        return $this->redirectToRoute('teacher_courses');
    }

    return $this->render('section/new.html.twig', [
        'form' => $form->createView(),
    ]);
}


    #[Route('/section/{id}', name: 'section_view')]

    public function view(Section $section)
    {
        return $this->render('section/view.html.twig', [
            'section' => $section,
        
        ]);
    }

    #[Route('/section/{id}/complete', name: 'complete_section')]

    public function CompleteSection(EntityManagerInterface $entityManager,$id): Response
    {
        $section = $entityManager->getRepository(Section::class)->find($id);
        $completed_section = new CompletedSections();
        $completed_section->setStudent($this->getUser());
        $completed_section->setSection($section);
        $entityManager->persist($completed_section);
        $entityManager->flush();

        $this->addFlash('success', 'Section created successfully');

        return $this->redirectToRoute('section_view',['id' => $id]);
    }
    #[Route('teacher/sections', name: 'manage_sections')]

    public function manageSections(): Response
    {   
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        $courses = $user->getCourses();

        return $this->render('teacher/manage_sections.html.twig', [
            'courses' => $courses
        ]);
    }

    public function edit(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $section = $entityManager->getRepository(Section::class)->find($id);

        if (!$section) {
            throw $this->createNotFoundException('Course not found');
        }

        $form = $this->createForm(SectionType::class, $section);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Section updated successfully.');

            return $this->redirectToRoute('teacher_courses');
        }

        return $this->render('/section/edit.html.twig', [
            'form' => $form->createView(),
            'section' => $section,
        ]);
    }

    public function delete($id , EntityManagerInterface $entityManager): Response
    {
        $section = $entityManager->getRepository(Section::class)->find($id);

        if (!$section) {
            throw $this->createNotFoundException('Section not found');
        }
        $entityManager->remove($section);
        $entityManager->flush();

        $this->addFlash('success', 'Section deleted successfully.');

        return $this->redirectToRoute('manage_sections');
    }
}
