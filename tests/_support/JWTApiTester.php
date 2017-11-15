<?php

/**
 * Created by PhpStorm.
 * User: Nimfus
 * Date: 14.11.2017
 * Time: 21:08
 */
class JWTApiTester extends \ApiTester
{
    const AUTH_URL = 'login';
    const SUPER_ADMIN_EMAIL = 'sincityprivate.super.admin@gmail.com';
    const SUPER_ADMIN_PASSWORD = '9P}\bwE9';

    /**
     * @param string $email
     * @param string $password
     *
     * @return string
     */
    public function generateToken($email, $password)
    {
        $this->sendPOST(static::AUTH_URL, [
            'email' => $email,
            'password' => $password
        ]);

        return $this->grabDataFromResponseByJsonPath('$.api.data.token')[0];
    }

    /**
     * @void
     */
    public function amAuthenticatedAsSuperAdmin()
    {
        $this->amBearerAuthenticated(
            $this->generateToken(static::SUPER_ADMIN_EMAIL, static::SUPER_ADMIN_PASSWORD)
        );
    }
}