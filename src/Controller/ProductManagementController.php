<?php

declare(strict_types=1);

namespace Roma\SyliusProductVariantPlugin\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Roma\SyliusProductVariantPlugin\Entity\ProductStock;
use App\Entity\Product\Product;
use Roma\SyliusProductVariantPlugin\Repository\ProductWithStockRepository;
use Roma\SyliusProductVariantPlugin\Repository\ProductStockRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class ProductManagementController
{
    /** @var Environment */
    private $twig;

    /** @var EntityManagerInterface */
    private $entityManager;

    public const TEMPLATE = '@RomaSyliusProductVariantPlugin/show.html.twig';

    public function __construct(Environment $twig,EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
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

    public function disable(Request $request): Response
    {
        $routeParams = $request->attributes->get('_route_params');
        $id = (int)$routeParams['id'];
        $EntityManager = $this->entityManager;
        $ProductStockRepository = $EntityManager->getRepository(ProductStock::class);
        $stock = $ProductStockRepository->findOneBy(['product' => $id]);

        if(!$stock){
            return  (new Response("Gone"))->setStatusCode(Response::HTTP_GONE);;
        }

        //dd($stock);
        $stock->setStockStatus(ProductStockRepository::PRODUCT_MISSING);
        $stock->setRestockDate((new \DateTime())->modify('+2 week'));
        $EntityManager->persist($stock);
        $EntityManager->flush();

        return new Response('success');
    }
    public function enable(Request $request): Response
    {

        $routeParams = $request->attributes->get('_route_params');
        $id = (int)$routeParams['id'];
        $EntityManager = $this->entityManager;
        $ProductStockRepository = $EntityManager->getRepository(ProductStock::class);
        $ProductWithStockRepository = $EntityManager->getRepository(Product::class);
        $stock = $ProductStockRepository->findOneBy(['product' => $id]);

        if(!$stock){
            $product = $ProductWithStockRepository->find($id);
            if(!$product){
                return  (new Response("Gone"))->setStatusCode(Response::HTTP_GONE);;
            }
            $stock = new ProductStock();
            $stock->setProduct($product);
        }

        $stock->setStockStatus(ProductStockRepository::PRODUCT_AVAILABLE);

        $EntityManager->persist($stock);
        $EntityManager->flush();

        return new Response('success');

    }

}
