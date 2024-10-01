<?php

namespace App\Controller;

use App\Entity\Sandwich;
use App\Repository\SandwichRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class SandwichController extends AbstractController
{
    #[Route('/api/sandwich', name: 'app_sandwich')]
    public function index(SandwichRepository $sandwichRepository): Response
    {

        $sandwiches = $sandwichRepository->findAll();

        return $this->json($sandwiches, 200, [], ['groups' => ['sandwichesjson']]);

    }

    #[Route('/api/me', name: 'app_me')]
    public function me(): Response
    {

        return $this->json($this->getUser(), 200, [], ['groups' => ['userjson']]);
    }

    #[Route('/api/create', name: 'create_sandwich', methods: ['POST'])]
    public function create(Request $request, SandwichRepository $sandwichRepository, SerializerInterface $serializer, EntityManagerInterface $manager, Security $security): JsonResponse
    {
        $sandwich = $serializer->deserialize($request->getContent(), Sandwich::class, 'json');
        $author = $security->getUser();
        if (!$author) {
            throw new AccessDeniedException('You must be logged in to create a sandwich.');
        }
        $sandwich->setAuthor($author);

        $manager->persist($sandwich);
        $manager->flush();

        return $this->json($sandwich, 200, [], ['groups' => ['sandwichesjson'], ["userjson"]]);


    }

    #[Route('/api/delete/{id}', name: 'app_sandwich_delete', methods: ['DELETE'])]
    public function delete(Request $request, Sandwich $sandwich, Security $security, EntityManagerInterface $manager): Response
    {
        if (!$sandwich) {
            return $this->json(['error' => 'Sandwich not found'], 404);
        }

        $user = $security->getUser();
        if ($sandwich->getAuthor() !== $user) {
            throw new AccessDeniedException('You are not allowed to delete this sandwich.');
        }

        $manager->remove($sandwich);
        $manager->flush();


        return $this->json(['message' => 'Sandwich deleted successfully'], 200);

    }

    #[Route('/api/edit/{id}', name: 'edit_sandwich', methods: ['PUT'])]
    public function edit(Request $request, Sandwich $sandwich, SandwichRepository $sandwichRepository, SerializerInterface $serializer, EntityManagerInterface $manager, Security $security): JsonResponse
    {
        if (!$sandwich) {
            return $this->json(['error' => 'Sandwich not found'], 404);
        }
        $user = $security->getUser();
        if ($sandwich->getAuthor() !== $user) {
            throw new AccessDeniedException('You are not allowed to edit this sandwich.');
        }

        $serializer->deserialize($request->getContent(), Sandwich::class, 'json', ['object_to_populate' => $sandwich]);

        $manager->flush();

        return $this->json($sandwich, 200, [], ['groups' => ['sandwichesjson', 'userjson']]);

    }
}
