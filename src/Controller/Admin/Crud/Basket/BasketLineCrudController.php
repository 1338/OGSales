<?php

namespace App\Controller\Admin\Crud\Basket;

use App\Entity\Basket\BasketLine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class BasketLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BasketLine::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            AssociationField::new('basket'),
            AssociationField::new('product'),
            NumberField::new('quantity'),
        ];
    }

}
