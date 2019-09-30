<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once("/var/www/php-crawler/Functions.php");

final class FunctionsTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testGetResult($token, $expected): void
    {
        $result = Functions::getResult($token);
        $this->assertEquals($expected, $result);
    }
    
    public function provider()
    {
        return [
            ["3wwv7xzu9750ux7754zzx75z17vvw651", "6dde2caf0249fc2245aac24a82eed348"],
            ["vy282w5uu3770x0012539yy917757288", "eb717d4ff6229c9987460bb082242711"],
            ["333v18w475854z4x202969w89002z6y9", "666e81d524145a5c797030d10997a3b0"], //27
            ["8xxvuxvyx5624910z3u4u7u0u43v9852", "1ccefcebc4375089a6f5f2f9f56e0147"], //46
        ];
    }
}
// 69f672c0d9f1522041d1948bd90335e5 76
// f761a1a5c9a2a7739c1231be03284e1c 50
// 2db72167d8f1f8bc247f83d7a1013404 75