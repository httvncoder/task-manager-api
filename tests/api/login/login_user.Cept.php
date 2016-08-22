<?php
use Codeception\Util\HttpCode;

$I = new ApiTester($scenario);

$I->wantTo('retrieve an access token for user');

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('auth/login', [
    'email' => 'admin@domain.com',
    'password' => '123'
]);

$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$token');
$I->seeResponseMatchesJsonType([
    'token' => 'string',
]);
