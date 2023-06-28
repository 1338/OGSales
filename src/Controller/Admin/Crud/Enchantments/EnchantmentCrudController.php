<?php

namespace App\Controller\Admin\Crud\Enchantments;

use App\Entity\Enchantments\Enchantment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EnchantmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enchantment::class;
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
