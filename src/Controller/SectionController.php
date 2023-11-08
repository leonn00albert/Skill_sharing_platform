<?php

namespace App\Controller;

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

    /**
 * @Route("/sections/new", name="section_new")
 */
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

        return $this->redirectToRoute('section_new');
    }

    return $this->render('section/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
