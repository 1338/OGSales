<?php

namespace App\Controller\Admin\Crud\Order;

use App\Entity\Order\OrderDeadDrop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderDeadDropCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDeadDrop::class;
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
