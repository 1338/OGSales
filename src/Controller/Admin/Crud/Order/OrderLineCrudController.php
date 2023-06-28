<?php

namespace App\Controller\Admin\Crud\Order;

use App\Entity\Order\OrderLine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class OrderLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderLine::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            AssociationField::new('mainOrder'),
            AssociationField::new('product'),
            NumberField::new('quantity'),
            NumberField::new('priceUnit'),
            NumberField::new('price'),

        ];
    }

}
