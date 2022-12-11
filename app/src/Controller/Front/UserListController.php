<?php

namespace App\Controller\Front;

use App\Application\Filters\Country\Service;
use App\Presenters\Transformers\Filters\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends AbstractController
{
    public function __construct(
        private readonly Service $service,
        private readonly Country $transformer
    ) {
    }

    #[Route('/')]
    public function list(): Response
    {
        $result = $this->service->handle();
        $transformedResult = [];

        foreach ($result->getAddresses() as $address) {
            $transformedResult[] = $this->transformer->transform($address);
        }

        $filters = json_encode(['countries' => $transformedResult]);

        return $this->render('user/list.html.twig', [
            'title' => 'Users List',
            'filters' => $filters,
        ]);
    }
}