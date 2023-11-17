<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student/enrollments', name: 'student_enrollments')]
    public function enrollments(): Response
    {
        $user = $this->getUser();
        $enrollments = $user->getEnrollments();

        return $this->render('student/enrollments.html.twig', [
            'enrollments' => $enrollments,
        ]);
    }
}