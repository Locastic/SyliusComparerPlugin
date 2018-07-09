<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Service;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerFactoryInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerProductFactoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ComparerCreator implements ComparerCreatorInterface
{
    /** @var ComparerFactoryInterface */
    private $comparerFactory;

    /** @var ComparerProductFactoryInterface */
    private $comparerProductFactory;

    /** @var RepositoryInterface */
    private $comparerRepository;

    /** @var ProductFactoryInterface */
    private $productFactory;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var int */
    private $comparerItemLimit;

    public function __construct(
        ComparerFactoryInterface $comparerFactory,
        ComparerProductFactoryInterface $comparerProductFactory,
        RepositoryInterface $comparerRepository,
        ProductFactoryInterface $productFactory,
        ChannelContextInterface $channelContext,
        ProductRepositoryInterface $productRepository,
        int $comparerItemLimit
    ) {
        $this->comparerFactory = $comparerFactory;
        $this->comparerProductFactory = $comparerProductFactory;
        $this->comparerRepository = $comparerRepository;
        $this->productFactory = $productFactory;
        $this->channelContext = $channelContext;
        $this->productRepository = $productRepository;
        $this->comparerItemLimit = $comparerItemLimit;
    }

    public function createComparerWithProductAndUser(ShopUserInterface $shopUser, string $productName): void
    {
        $comparer = $this->comparerFactory->createForShopUser($shopUser);
        $product = $this->createProduct($productName);
        $comparerProduct = $this->comparerProductFactory->createForComparerAndProduct($comparer, $product);

        $comparer->addComparerProduct($comparerProduct);

        $this->comparerRepository->add($comparer);
    }

    public function createFullComparer(): void
    {
        /** @var ComparerInterface */
        $comparer = $this->comparerFactory->createNew();

        $this->addMaximumAmountOfItemsToComparer($comparer);

        $this->comparerRepository->add($comparer);
    }

    private function createProduct(string $name): ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->productFactory->createNew();

        $product->setName($name);
        $product->setCode(StringInflector::nameToCode($name));
        $product->setSlug(StringInflector::nameToCode($name));
        $product->addChannel($this->channelContext->getChannel());

        $this->productRepository->add($product);

        return $product;
    }

    private function addMaximumAmountOfItemsToComparer(ComparerInterface $comparer, int $counter = 0)
    {
        while ($counter++ < $this->comparerItemLimit) {
            /** @var ProductInterface */
            $product = $this->createProduct('product' . $counter);

            /** @var ComparerProductInterface */
            $comparerProduct = $this->comparerProductFactory->createForComparerAndProduct($comparer, $product);

            $comparer->addComparerProduct($comparerProduct);
        }
    }
}
