<?php
/**
 * Created by PhpStorm.
 * User: Duje
 * Date: 29-May-18
 * Time: 2:31 PM
 */
declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

interface ComparerTokenInterface
{
    const TOKEN_LENGTH = 50;

    public function provide(): string;
}
