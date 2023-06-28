<?php

namespace App\Controller\Admin\Crud\Catalog;

use App\Entity\Catalog\CatalogItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CatalogItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CatalogItem::class;
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
