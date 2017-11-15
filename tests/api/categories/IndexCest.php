<?php
namespace Tests\Api\Categories;

class IndexCest
{
    public function testIndexPage(\JWTApiTester $I)
    {
        $I->sendGET('categories');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }
}