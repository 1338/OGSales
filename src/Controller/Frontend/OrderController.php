<?php

namespace App\Controller\Frontend;

use App\Entity\Order\Orders;
use App\Entity\Order\OrderStatus;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private EntityManagerInterface $em;

    private PaginationService $paginationService;

    public function __construct(EntityManagerInterface $em, PaginationService $paginationService)
    {
        $this->em = $em;
        $this->paginationService = $paginationService;
    }


    #[Route('/orders', name: 'app_frontend_orders')]
    public function index(Request $request): Response
    {
        $form = $this->createOrdersForm($request);

        $form->handleRequest($request);

        $pagination = $this->paginationService->getPaginationFromForm(
            $form->getData() ?? [],
            Orders::class
        );

        return $this->render('@App/frontend/order/index.html.twig', [
            'pagination' => $pagination,
            'count' => $pagination->count(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/order/{id}', name: 'app_frontend_order_show')]
    public function show($id): Response
    {
        // check if user has access to this order
        $order = $this->em->getRepository(Orders::class)->findOneBy([
            'id' => $id,
            'user' => $this->getUser()
        ]);

        if ($order) {
            return $this->render('frontend/order/show.html.twig', [
                'order' => $order,
            ]);
        }

        return $this->redirectToRoute('app_frontend_order');
    }

    #[Route('/order/{id}/cancel', name: 'app_frontend_order_cancel')]
    public function cancel($id): Response
    {
        // check if user has access to this order
        $order = $this->em->getRepository(Orders::class)->findOneBy([
            'id' => $id,
            'user' => $this->getUser()
        ]);

        if ($order) {
            $order->setStatus($this->em->getRepository(OrderStatus::class)->findOneBy([
                'name' => 'cancelled'
            ]));

            $this->em->persist($order);
            $this->em->flush();
        }

        return $this->redirectToRoute('app_frontend_order');
    }

    public function createOrdersForm(Request $request)
    {
        return $this->createFormBuilder()->add('order', ChoiceType::class, [
                'choices'  => [
                    'ASC'  => 'ASC',
                    'DESC' => 'DESC'
                ],
                'required' => false,
                'data' => 'DESC'
            ])->add('orderBy', ChoiceType::class, [
                'choices'  => [
                    'ID'     => 'id',
                    'Date'   => 'date',
                    'Status' => 'status'
                ],
                'required' => false
            ])->add('page', HiddenType::class, [
                'required' => false
            ])->add('limit', ChoiceType::class, [
                'choices'  => [
                    '10'  => 10,
                    '20'  => 20,
                    '50'  => 50,
                    '100' => 100
                ],
                'required' => false
            ])->add('search', TextType::class, [
                'required' => false
            ])->add('submit', SubmitType::class, [
                'label' => 'Search'
            ])->getForm()
        ;
    }
}
