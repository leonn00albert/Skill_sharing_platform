<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
    #[Route('/test/clean/user', name: 'clean_user')]
    public function cleanUser(EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager->getRepository(User::class);

        $user = $userRepository->findOneBy(['email' => 'teacher@acceptiontest.com']);

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();

            return new Response('User deleted successfully.');
        }

        return new Response('User not found.', 404);
    }
}
