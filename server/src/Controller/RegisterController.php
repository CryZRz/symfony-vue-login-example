<?php

namespace App\Controller;

use App\Dto\CreateUserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/register', name: 'app_register', methods: 'POST')]
    public function index(
        #[MapRequestPayload] CreateUserDto $request,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse
    {
        $user = new User();
        $email = $request->email;
        $password = $request->password;
        $roles = $request->roles;

        $passwordHash = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setEmail($email);
        $user->setPassword($passwordHash);
        $user->setRoles($roles);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => "user has ben created with id ".$user->getId(),
            'path' => 'src/Controller/RegisterController.php',
        ]);
    }
}
