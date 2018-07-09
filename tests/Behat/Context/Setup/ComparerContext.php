<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerFactoryInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerProductFactoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * Defines application features from the specific context.
 */
class ComparerContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    /** @var ComparerFactoryInterface */
    private $comparerFactory;

    /** @var ComparerProductFactoryInterface */
    private $comparerProductFactory;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var EntityManagerInterface */
    private $productTaxonManager;

    /** @var FactoryInterface */
    private $taxonFactory;

    /** @var FactoryInterface */
    private $productTaxonFactory;

    public function __construct(
        ComparerFactoryInterface $comparerFactory,
        ComparerProductFactoryInterface $comparerProductFactory,
        ProductRepositoryInterface $productRepository,
        EntityManagerInterface $productTaxonManager,
        FactoryInterface $taxonFactory,
        FactoryInterface $productTaxonFactory
    ) {
        $this->comparerFactory = $comparerFactory;
        $this->comparerProductFactory = $comparerProductFactory;
        $this->productRepository = $productRepository;
        $this->productTaxonManager = $productTaxonManager;
        $this->taxonFactory = $taxonFactory;
        $this->productTaxonFactory = $productTaxonFactory;
    }

    /**
     * @Given all store products appear under a main taxonomy
     */
    public function allStoreProductsAppearUnderAMainTaxonomy()
    {
        /** @var TaxonInterface $taxon */
        $taxon = $this->taxonFactory->createNew();
        $taxon->setCode('main');
        $taxon->setSlug('main');
        $taxon->setName('Main');

        /** @var ProductInterface $product */
        foreach ($this->productRepository->findAll() as $product) {
            /** @var ProductTaxonInterface $productTaxon */
            $productTaxon = $this->productTaxonFactory->createNew();
            $productTaxon->setTaxon($taxon);
            $productTaxon->setProduct($product);
            $product->addProductTaxon($productTaxon);
            $this->productTaxonManager->persist($taxon);
            $this->productTaxonManager->persist($productTaxon);
            $this->productTaxonManager->flush();
        }
    }

    /**
     * @Given I added maximum amount of products to comparer
     */
    public function iAddedMaximumAmountOfProductsToComparer()
    {
    }
}
