<?php

namespace App\Controller;

use App\Repository\SandwichRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SandwichController extends AbstractController
{
    #[Route('/sandwich', name: 'app_sandwich')]
    public function index(SandwichRepository $sandwichRepository): Response
    {

        $sandwiches = $sandwichRepository->findAll();

        return $this->json($sandwiches, 200, [], ['groups' => ['sandwichesjson']]);

    }
}
