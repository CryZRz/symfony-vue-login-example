<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/auth', name: 'app_auth')]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        if ($user != null){
            return $this->json([
                "user" => "hola"
            ]);
        }

        return $this->json([
            "message" => "not logged"
        ], Response::HTTP_UNAUTHORIZED);
    }
}
