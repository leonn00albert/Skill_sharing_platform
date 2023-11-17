<?php
// src/Controller/LogoutController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class LogoutController extends AbstractController 
{
    #[Route('/logout', name: 'app_logout')]

    public function logout(): void
    {
  
        throw new \Exception('This should not be reached!');
    }

    public function onLogoutSuccess(Request $request): RedirectResponse
    {
        // Redirect to the homepage or any other route after logout
        return $this->redirectToRoute('homepage');
    }
}
