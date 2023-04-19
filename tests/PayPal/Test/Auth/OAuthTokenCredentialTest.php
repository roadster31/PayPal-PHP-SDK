<?php

namespace PayPal\Test\Auth;

use PayPal\Exception\PayPalConnectionException;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Cache\AuthorizationCache;
use PayPal\Core\PayPalConfigManager;
use PayPal\Rest\ApiContext;
use PayPal\Test\Cache\AuthorizationCacheTest;
use PayPal\Test\Constants;
use PHPUnit\Framework\TestCase;

class OAuthTokenCredentialTest extends TestCase
{

    /**
     * @group integration
     */
    public function testGetAccessToken()
    {
        $cred = new OAuthTokenCredential(Constants::CLIENT_ID, Constants::CLIENT_SECRET);
        $this->assertEquals(Constants::CLIENT_ID, $cred->getClientId());
        $this->assertEquals(Constants::CLIENT_SECRET, $cred->getClientSecret());
        $config = PayPalConfigManager::getInstance()->getConfigHashmap();
        $token = $cred->getAccessToken($config);
        $this->assertNotNull($token);

        // Check that we get the same token when issuing a new call before token expiry
        $newToken = $cred->getAccessToken($config);
        $this->assertNotNull($newToken);
        $this->assertEquals($token, $newToken);
    }

    /**
     * @group integration
     */
    public function testInvalidCredentials()
    {
        $this->setExpectedException(PayPalConnectionException::class);
        $cred = new OAuthTokenCredential('dummy', 'secret');
        $this->assertNull($cred->getAccessToken(PayPalConfigManager::getInstance()->getConfigHashmap()));
    }

    public function testGetAccessTokenUnit()
    {
        $config = ['mode' => 'sandbox', 'cache.enabled' => true, 'cache.FileName' => AuthorizationCacheTest::CACHE_FILE];
        $cred = new OAuthTokenCredential('clientId', 'clientSecret');

        //{"clientId":{"clientId":"clientId","accessToken":"accessToken","tokenCreateTime":1421204091,"tokenExpiresIn":288000000}}
        AuthorizationCache::push($config, 'clientId', $cred->encrypt('accessToken'), 1_421_204_091, 288_000_000);

        $apiContext = new ApiContext($cred);
        $apiContext->setConfig($config);
        $this->assertEquals('clientId', $cred->getClientId());
        $this->assertEquals('clientSecret', $cred->getClientSecret());
        $result = $cred->getAccessToken($config);
        $this->assertNotNull($result);
    }

    public function testGetAccessTokenUnitMock()
    {
        $config = ['mode' => 'sandbox'];
        /** @var OAuthTokenCredential $auth */
        $auth = $this->getMockBuilder('\\' . OAuthTokenCredential::class)
            ->setConstructorArgs(['clientId', 'clientSecret'])
            ->setMethods(['getToken'])
            ->getMock();

        $auth->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(
                ['refresh_token' => 'refresh_token_value']
            ));
        $response = $auth->getRefreshToken($config, 'auth_value');
        $this->assertNotNull($response);
        $this->assertEquals('refresh_token_value', $response);
    }

    public function testUpdateAccessTokenUnitMock()
    {
        $config = ['mode' => 'sandbox'];
        /** @var OAuthTokenCredential $auth */
        $auth = $this->getMockBuilder('\\' . OAuthTokenCredential::class)
            ->setConstructorArgs(['clientId', 'clientSecret'])
            ->setMethods(['getToken'])
            ->getMock();

        $auth->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(
                ['access_token' => 'accessToken', 'expires_in' => 280]
            ));

        $response = $auth->updateAccessToken($config);
        $this->assertNotNull($response);
        $this->assertEquals('accessToken', $response);

        $response = $auth->updateAccessToken($config, 'refresh_token');
        $this->assertNotNull($response);
        $this->assertEquals('accessToken', $response);
    }

    /**
     * @expectedException \PayPal\Exception\PayPalConnectionException
     * @expectedExceptionMessage Could not generate new Access token. Invalid response from server:
     */
    public function testUpdateAccessTokenNullReturnUnitMock()
    {
        $config = ['mode' => 'sandbox'];
        /** @var OAuthTokenCredential $auth */
        $auth = $this->getMockBuilder('\\' . OAuthTokenCredential::class)
            ->setConstructorArgs(['clientId', 'clientSecret'])
            ->setMethods(['getToken'])
            ->getMock();

        $auth->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(
                []
            ));

        $response = $auth->updateAccessToken($config);
        $this->assertNotNull($response);
        $this->assertEquals('accessToken', $response);
    }
}
