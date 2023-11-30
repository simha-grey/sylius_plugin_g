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
        $offset = max(0, $routeParams['offset']);
        $status = max(0, $routeParams['status']);
        $paginator = $ProductWithStockRepository->getProductWithStockPaginator($offset, $status);

        return new Response($this->twig->render(self::TEMPLATE,[
            'data' => $paginator,
            'status' => $status,
            'previous' => $offset - ProductWithStockRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProductWithStockRepository::PAGINATOR_PER_PAGE),
        ]));

    }

}
