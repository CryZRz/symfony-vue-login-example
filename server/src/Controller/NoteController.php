<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class NoteController extends AbstractController
{
    private $noteRepository;
    private $entityManager;
    public function __construct(
        NoteRepository $noteRepository,
        EntityManagerInterface $entityManager
    ){
        $this->noteRepository = $noteRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/notes', name: 'app_note', methods: 'GET')]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        $notes = $this->noteRepository->findByUserId($user->getId());

        return $this->json([
            "notes" => $notes
        ], Response::HTTP_OK, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ["userId"]
        ]);
    }

    #[Route('/api/notes', methods: "POST")]
    public function create(Request $request): JsonResponse
    {
        $note = new Note();
        $body = $request->toArray();
        $user = $this->getUser();
        $title = $body["title"];
        $description = $body["description"];

        $note->setTitle($title);
        $note->setDescription($description);
        $note->setUserId($user);

        $this->entityManager->persist($note);
        $this->entityManager->flush();

        return $this->json([
            "note" => $note
        ], Response::HTTP_OK, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ["userId"]
        ]);
    }

    #[Route('/api/notes/{id}', name: 'create_note', methods: "PUT")]
    public function update(int $id, Request $request): JsonResponse
    {
        $body = $request->toArray();
        $user = $this->getUser();
        $note = $this->noteRepository->find($id);
        $title = $body["title"];
        $description = $body["description"];

        if ($note->getUserId()->getId() != $user->getId()){
            return $this->json([
                "message" => "You don't have permission to edit this note"
            ], Response::HTTP_UNAUTHORIZED);
        }

        $note->setTitle($title);
        $note->setDescription($description);
        $this->entityManager->persist($note);
        $this->entityManager->flush();


        return $this->json([
            "message" => "note has ben updated"
        ]);
    }

    #[Route('/api/notes/{id}', methods: 'DELETE')]
    public function destroy(int $id): JsonResponse
    {
        $user = $this->getUser();
        $note = $this->noteRepository->find($id);
        if ($note != null){

            if ($note->getUserId()->getId() != $user->getId()){
                return $this->json([
                    "message" => "You don't have permission to delete this note"
                ], Response::HTTP_UNAUTHORIZED);
            }

            $this->entityManager->remove($note);
            $this->entityManager->flush();

            return $this->json([
                "message" => "note has ben removed"
            ]);
        }

        return $this->json([
            "message" => "note not found"
        ], Response::HTTP_NOT_FOUND);
    }
}
