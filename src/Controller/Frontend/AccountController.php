<?php

namespace App\Controller\Frontend;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_frontend_account')]
    public function index(EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $em->getRepository(User::class)->find($this->getUser()->getId());

        return $this->render('@App/frontend/account/index.html.twig', [
            'user' => $user
        ]);
    }
}
