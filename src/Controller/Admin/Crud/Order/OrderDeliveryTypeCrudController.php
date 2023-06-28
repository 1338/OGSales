<?php

namespace App\Controller\Admin\Crud\Order;

use App\Entity\Order\OrderDeliveryType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderDeliveryTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDeliveryType::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            TextField::new('name'),
        ];
    }

}
