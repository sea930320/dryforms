<?php
namespace Tests\Api\Auth;

class AuthCest
{
    /**
     * @param \ApiTester $I
     */
    public function testLogin(\ApiTester $I)
    {
        $credentials = [
            'email' => 'sincityprivate.super.admin@gmail.com',
            'password' => '9P}\bwE9'
        ];
        $I->sendPOST('login', $credentials);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $token = $I->grabDataFromResponseByJsonPath('$.access_token')[0];

        \PHPUnit_Framework_Assert::assertEquals(305, strlen($token));
    }

    /**
     * @param \ApiTester $I
     */
    public function testLoginFailure(\ApiTester $I)
    {
        $credentials = [
            'email' => '123123@gmail.com',
            'password' => '9P}\bwE9'
        ];
        $I->sendPOST('login', $credentials);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(401);
    }
}