<?php

namespace App\Controller\Frontend;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    #[Route('/basket', name: 'app_frontend_basket')]
    public function index(EntityManagerInterface $em): Response
    {
        if($this->getUser() === null) {
            return $this->redirectToRoute('app_frontend_index');
        }


        /** @var User $user */
        $user = $em->getRepository(User::class)->find($this->getUser()->getId());

        return $this->render('@App/frontend/basket/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/basket/add/{id}', name: 'app_frontend_basket_add')]
    public function add(EntityManagerInterface $em, $id): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_frontend_index');
        }

        /** @var User $user */
        $user = $em->getRepository(User::class)->find($this->getUser()->getId());

        $basket = $user->getBasket();

        $form = $this->createFormBuilder()
            ->add('quantity', HiddenType::class, [
                'data' => $basket->getQuantity() + 1
            ])
            ->add('save', SubmitType::class, ['label' => 'Update Basket'])
            ->getForm();


        $basket->getBasketLineForProduct($id);

        //$user->getBasket()->addBasketLine();

        //$user->addBasketItem($id);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_frontend_basket');
    }
}
