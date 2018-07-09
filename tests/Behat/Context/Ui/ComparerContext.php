<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Tests\Locastic\SyliusComparerPlugin\Behat\Page\Shop\ComparerPageInterface;
use Tests\Locastic\SyliusComparerPlugin\Behat\Page\Shop\ProductHomePageInterface;
use Tests\Locastic\SyliusComparerPlugin\Behat\Service\ComparerCreatorInterface;
use Webmozart\Assert\Assert;

final class ComparerContext extends MinkContext implements Context
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ProductHomePageInterface */
    private $homePage;

    /** @var ComparerPageInterface */
    private $comparerPage;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var ComparerCreatorInterface */
    private $comparerCreator;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductHomePageInterface $homePage,
        ComparerPageInterface $comparerPage,
        NotificationCheckerInterface $notificationChecker,
        ComparerCreatorInterface $comparerCreator
    ) {
        $this->productRepository = $productRepository;
        $this->homePage = $homePage;
        $this->comparerPage = $comparerPage;
        $this->notificationChecker = $notificationChecker;
        $this->comparerCreator = $comparerCreator;
    }

    /**
     * @When /^I add this product to comparer$/
     */
    public function iAddThisProductToComparer(): void
    {
        /** @var ProductInterface */
        $product = $this->productRepository->findOneBy([]);

        $this->homePage->addProductToComparer($product->getName());
    }

    /**
     * @When I add the :productName product to comparer
     */
    public function iAddProductToComparer(string $productName)
    {
        $this->homePage->addProductToComparer($productName);
    }

    /**
     * @When I go to the comparer page
     */
    public function iGoToTheComparerPage(): void
    {
        $this->comparerPage->open();
    }

    /**
     * @Given I add :productName1, :productName2, :productName3 products to comparer
     */
    public function iAddedProductsToComparer(string $productName1, string $productName2, string $productName3)
    {
        $products = new ArrayCollection([$productName1, $productName2, $productName3]);
        $this->addProductsToComparer($products);
    }

    /**
     * @When I remove this product from comparer
     */
    public function iRemoveThisProduct(): void
    {
        $this->comparerPage->removeProduct($this->productRepository->findOneBy([])->getName());
    }

    /**
     * @When I remove the :productName product from comparer
     */
    public function iRemoveProduct(string $productName): void
    {
        $this->comparerPage->removeProduct($productName);
    }

    /**
     * @Then I should be on comparer page
     */
    public function iShouldBeOnComparerPage(): void
    {
        $this->comparerPage->verify();
    }

    /**
     * @Then I should be notified that the product has been successfully added to comparer
     */
    public function iShouldBeNotifiedThatTheProductHasBeenSuccessfullyAddedToComparer(): void
    {
        $this->notificationChecker->checkNotification('Selected product has been successfully added to comparer.', NotificationType::success());
    }

    /**
     * @Then I should be notified that the product has been successfully removed from comparer
     */
    public function iShouldBeNotifiedThatTheProductHasBeenRemovedFromComparer(): void
    {
        $this->notificationChecker->checkNotification('Selected product has been successfully removed from comparer.', NotificationType::success());
    }

    /**
     * @Then I should be notified that product cannot be added to comparer due to full comparer
     */
    public function iShouldBeNotifiedThatProductCannotBeAddedToComparerDueToFullComparer()
    {
        $this->notificationChecker->checkNotification('Your comparer contains maximum amount of possible items.', NotificationType::failure());
    }

    /**
     * @Then I should be notified that product cannot be added to comparer because Its already in comparer
     */
    public function iShouldBeNotifiedThatProductCannotBeAddedToComparerBecauseItsAlreadyInComparer()
    {
        $this->notificationChecker->checkNotification('Comparer already contains added product.', NotificationType::failure());
    }

    /**
     * @Then I should have :productName product in comparer
     */
    public function iShouldHaveProductInComparer(string $productName): void
    {
        Assert::true($this->comparerPage->hasProduct($productName));
    }

    /**
     * @Then I should have :productName product in my cart
     */
    public function iShouldHaveProductInMyCart(string $productName): void
    {
        Assert::true(
            $this->comparerPage->hasProductInCart($productName),
            sprintf('Product %s was not found in the cart.', $productName)
        );
    }

    /**
     * @When I add :productName product to the comparer
     */
    public function iAddProductToTheComparer(string $productName)
    {
        $this->homePage->addProductToComparer($productName);
    }

    /**
     * @Then I should have this product in my comparer
     */
    public function iShouldHaveThisProductInMyComparer()
    {
        $productName = $this->productRepository->findOneBy([])->getName();

        Assert::true(
            $this->comparerPage->hasProduct($productName),
            sprintf('Product %s was not found in the comparer.', $productName)
        );
    }

    /**
     * @Then I should have the :productName product in my comparer
     */
    public function iShouldHaveProductInMyComparer(string $productName)
    {
        Assert::true(
            $this->comparerPage->hasProduct($productName),
            sprintf('Product %s was not found in the comparer.', $productName)
        );
    }

    /**
     * @Then I should not have :productName product in my comparer
     */
    public function iShouldNotHaveThisProductInMyComparer(string $productName)
    {
        Assert::false(
            $this->comparerPage->hasProduct($productName),
            sprintf('Product %s was not found in the comparer.', $productName)
        );
    }

    /**
     * @Given the comparer is full
     */
    public function theComparerIsFull()
    {
        $this->comparerCreator->createFullComparer();
    }

    private function addProductsToComparer(ArrayCollection $products)
    {
        $products->map(function ($productName) {
            $this->homePage->addProductToComparer($productName);
        });
    }
}
