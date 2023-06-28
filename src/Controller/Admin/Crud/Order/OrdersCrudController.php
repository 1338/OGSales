<?php

namespace App\Controller\Admin\Crud\Order;

use App\Entity\Order\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            AssociationField::new('orderLines')
                            ->setFormTypeOptions([
                                'by_reference' => false,
                            ]),
            AssociationField::new('user'),
            AssociationField::new('status'),
            AssociationField::new('deliveryType'),
            AssociationField::new('deadDrop'),
        ];
    }

}
