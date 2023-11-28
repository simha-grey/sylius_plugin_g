<?php

declare(strict_types=1);

namespace Roma\SyliusProductVariantPlugin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Roma\SyliusProductVariantPlugin\Repository\ProductStockRepository;
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

    public function show(Request $request, ProductStockRepository $ProductStockRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $status = max(0, $request->query->getInt('status', 0));
        $paginator = $ProductStockRepository->getProductStock($offset, $status);

        return new Response($this->twig->render(self::TEMPLATE,[
            'data' => $paginator,
            'previous' => $offset - ProductStockRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProductStockRepository::PAGINATOR_PER_PAGE),
        ]));

    }

}
