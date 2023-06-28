<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class PaginationService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getPaginationFromForm(array $formData, $entity)
    {

        $page = $formData['page'] ?? 1;
        $limit = $formData['limit'] ?? 10;
        $searchTerm = $formData['searchTerm'] ?? null;
        $searchField = $formData['searchField'] ?? null;
        $order = $formData['order'] ?? 'DESC';
        $orderBy = $formData['orderBy'] ?? 'id';

        return $this->getPagination(
            $entity,
            $page,
            $limit,
            $searchField,
            $searchTerm,
            $order,
            $orderBy
        );
    }

    public function getPagination(
        $entity,
        $page = 1,
        $limit = 20,
        $searchField = null,
        $searchTerm = null,
        $order = 'DESC',
        $orderBy = 'id'
    ) {
        $offset = ($page - 1) * $limit;

        $query = $this->em->createQueryBuilder()
            ->select('e')
            ->from($entity, 'e')
            ->orderBy('e.' . $orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        if ($searchField && $searchTerm) {

            // we need to sanitize the search field and term
            $searchField = preg_replace('/[^a-z0-9_]/i', '', $searchField);
            $searchTerm = preg_replace('/[^a-z0-9_]/i', '', $searchTerm);

            $query->where('e.' . $searchField . ' LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        return new Paginator($query);
    }
}