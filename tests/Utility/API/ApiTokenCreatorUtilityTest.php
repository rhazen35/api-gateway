<?php

declare(strict_types=1);

namespace App\Tests\Utility\API;

use PHPUnit\Framework\TestCase;

final class ApiTokenCreatorUtilityTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param $token
     */
    public function testCreateToken($token)
    {
        $this->assertIsString($token);
    }

    public function dataProvider()
    {
        return [
            ['wlkgafnagklbndlfskgndskgns234242424k2jli42kn4jk24'],
            ['3li54l34k5n3kljb63kj6b34jk6b3jk6n3kj5n3kjln5k3l4n5kj3n5k3n'],
            ['liu3hbt2893nvz5p392vnzp938bnp23n96v96bu23p986b24p986bu24p62bup9682bun'],
        ];
    }
}