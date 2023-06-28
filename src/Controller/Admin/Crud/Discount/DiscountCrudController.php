<?php

namespace App\Controller\Admin\Crud\Discount;

use App\Entity\Discount\Discount;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DiscountCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Discount::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
