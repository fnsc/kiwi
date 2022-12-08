<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends AbstractController
{
    #[Route('/')]
    public function list(): Response
    {
        return $this->render('user/list.html.twig', [
            'title' => 'Users List',
        ]);
    }
}