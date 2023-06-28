<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Crud\Order\OrdersCrudController;
use App\Entity\Basket\Basket;
use App\Entity\Basket\BasketLine;
use App\Entity\Catalog\CatalogItem;
use App\Entity\Order\OrderDeadDrop;
use App\Entity\Order\OrderDeliveryType;
use App\Entity\Order\OrderLine;
use App\Entity\Order\Orders;
use App\Entity\Order\OrderStatus;
use App\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(OrdersCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Project');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::subMenu(
                'Order',
                'fas fa-list',
            )->setSubItems([
                MenuItem::linkToCrud('Orders', 'fas fa-list', Orders::class),
                MenuItem::linkToCrud('Order Lines', 'fas fa-list', OrderLine::class),
                MenuItem::linkToCrud('Order Status', 'fas fa-list', OrderStatus::class),
                MenuItem::linkToCrud('Order Delivery Type', 'fas fa-list', OrderDeliveryType::class),
                MenuItem::linkToCrud('Order DeadDrop', 'fas fa-list', OrderDeadDrop::class),
            ]),
            MenuItem::subMenu('Basket', 'fas fa-list')->setSubItems([
                MenuItem::linkToCrud('Baskets', 'fas fa-list', Basket::class),
                MenuItem::linkToCrud('Basket Lines', 'fas fa-list', BasketLine::class),
            ]),
            MenuItem::subMenu('Catalog', 'fas fa-list')->setSubItems([
                MenuItem::linkToCrud('Catalog Items', 'fas fa-list', CatalogItem::class),
            ]),
            MenuItem::linkToCrud('Users', 'fas fa-list', User::class),
        ];
    }
}
