<?php

declare(strict_types=1);

namespace Roma\SyliusProductVariantPlugin\Controller;

use Roma\SyliusProductVariantPlugin\Repository\ProductWithStockRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class ProductManagementController
{
    /** @var Environment */
    private $twig;

    public const TEMPLATE = '@RomaSyliusProductVariantPlugin/show.html.twig';

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function show(Request $request, ProductWithStockRepository $ProductWithStockRepository): Response
    {
        $routeParams = $request->attributes->get('_route_params');
        $offset = max(0, (int)$routeParams['offset']);
        $status = max(0, (int)$routeParams['status']);
        //ProductWithStockRepository may be should be combined with StockRepository
        //For consideration. If it will be required by modification base Product controller in future
        $paginator = $ProductWithStockRepository->getProductWithStockPaginator($offset, $status);

        return new Response($this->twig->render(self::TEMPLATE,[
            'data' => $paginator,
            'status' => $status,
            'previous' => $offset - ProductWithStockRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProductWithStockRepository::PAGINATOR_PER_PAGE),
        ]));

    }

    public function disable(Request $request, ProductStockRepository $ProductStockRepository): Response
    {
        $routeParams = $request->attributes->get('_route_params');
        $offset = max(0, (int)$routeParams['offset']);
        $status = max(0, (int)$routeParams['status']);
        $id = (int)$routeParams['id'];
        $entity = $ProductStockRepository->FindByProduct($id);

        if($entity){
            $ProductStockRepository->disable($entity,true);
        }
        return $this->redirectToRoute('roma_product_management_show', ['offset' => $offset, 'status' => $status]);

    }

}
