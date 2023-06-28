<?php

namespace App\Controller\Frontend;

use App\Entity\Catalog\CatalogItem;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private PaginationService $paginationService;

    public function __construct(PaginationService $paginationService)
    {
        $this->paginationService = $paginationService;
    }


    #[Route('/', name: 'app_frontend_index')]
    public function index(Request $request): Response
    {
        $form = $this->createProductSearchForm($request);

        $form->handleRequest($request);
        $paginationParams = [];
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $paginationParams = $form->getData();
        }

        if (empty($paginationParams['order'])) {
            $paginationParams['order'] = 'ASC';
        }
        if (empty($paginationParams['orderBy'])) {
            $paginationParams['orderBy'] = 'name';
        }

        $pagination = $this->paginationService->getPaginationFromForm(
            $paginationParams,
            CatalogItem::class
        );



        return $this->render('@App/frontend/index/index.html.twig', [
            'paginator' => $pagination,
            'count' => $pagination->count(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return FormInterface
     */
    public function createProductSearchForm(Request $request): FormInterface
    {
        return $this->createFormBuilder()
                    ->add(
                        'searchTerm',
                        TextType::class,
                        [
                            'label'    => 'Search',
                            'required' => false,
                            'attr'     => [
                                'placeholder' => 'Search'
                            ],
                            'data'     => $request->query->get('searchTerm')
                        ]
                    )
                    ->add(
                        'searchField',
                        HiddenType::class,
                        [
                            'label'    => 'Search Field',
                            'required' => false,
                            'attr'     => [
                                'placeholder' => 'Search Field'
                            ],
                            'data'     => 'name'
                        ]
                    )
                    ->add(
                        'orderBy',
                        ChoiceType::class,
                        [
                            'label'    => '',
                            'required' => false,
                            'attr'     => [
                                'placeholder' => 'Order By'
                            ],
                            'data'     => $request->query->get('orderBy'),
                            'choices'  => [
                                'Name' => 'name',
                                'Price' => 'price',
                                'Stock' => 'stock'
                            ]
                        ]
                    )
                    ->add(
                        'order',
                        ChoiceType::class,
                        [
                            'label'    => 'Order',
                            'required' => false,
                            'attr'     => [
                                'placeholder' => 'Order'
                            ],
                            'data'     => $request->query->get('order'),
                            'choices'  => [
                                'Ascending' => 'ASC',
                                'Descending' => 'DESC'
                            ]
                        ]
                    )
                    ->add(
                        'submit',
                        SubmitType::class,
                        [
                            'label' => 'Search'
                        ]
                    )
                    ->getForm()
        ;
    }
}
