<?php
/**
 * Created by PhpStorm.
 * User: Duje
 * Date: 29-May-18
 * Time: 2:34 PM
 */
declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Sylius\Component\Resource\Generator\RandomnessGeneratorInterface;

final class ComparerToken implements ComparerTokenInterface
{
    /** @var RandomnessGeneratorInterface */
    private $randomGenerator;

    public function __construct(RandomnessGeneratorInterface $randomGenerator)
    {
        $this->randomGenerator = $randomGenerator;
    }

    public function provide(): string
    {
        $token = $this->randomGenerator->generateUriSafeString(self::TOKEN_LENGTH);

        return $token;
    }
}
