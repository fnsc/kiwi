<?php

namespace App\Controller\Api;

use App\Application\UserList\InputBoundary;
use App\Application\UserList\Service;
use App\Presenters\Transformers\UserListTransformer;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends AbstractController
{
    public function __construct(
        private readonly Service             $service,
        private readonly UserListTransformer $transformer,
        private readonly LoggerInterface     $logger
    ) {
    }

    #[Route('api/v1/users')]
    public function list(Request $request): JsonResponse
    {
        try {
            $input = new InputBoundary($request->get('term') ?? '');
            $result = $this->service->handle($input);
            $transformedData = [];

            foreach ($result->getUsers() as $user) {
                $transformedData[] = $this->transformer->transform($user);
            }

            return new JsonResponse([
                'users' => $transformedData,
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $this->logger->error('[UserList|API] Something unexpected has happened.', compact('exception'));

            return new JsonResponse([
                'errors' => [
                    'server' => 'Something unexpected has happened.'
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}