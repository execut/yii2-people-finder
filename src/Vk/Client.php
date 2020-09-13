<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Vk;


use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiAuthException;
use VK\Exceptions\Api\VKApiPrivateProfileException;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use yii\base\Exception;

class Client
{
    public function request($params, $area = 'friends', $method = 'search')
    {
        $cache = \yii::$app->cache;
        $cacheKey = __CLASS__ . var_export($params, true) . '-' . $area . '-' . $method;
        if (($result = $cache->get($cacheKey)) !== false) {
            return $result;
        }

        usleep(100000);
        $result = false;
        for ($key = 0; $key < 2; $key++) {
            try {
                $token = getenv('VK_ACCESS_TOKEN');
                if (!$token) {
                    $this->requestAccessToken();
                }

                $vk = new VKApiClient();
                $result = $vk->$area()->$method($token, $params);
                usleep(300000);
                break;
            } catch (VKApiAuthException $e) {
                $this->requestAccessToken();
            } catch (VKApiPrivateProfileException $e) {
                $result = [];
                break;
            }
        }

        $cache->set($cacheKey, $result);

        return $result;
    }

    protected function requestAccessToken()
    {
        $oauth = new VKOAuth();
        $client_id = 7581693;
        $redirect_uri = 'http://127.0.0.1';
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::FRIENDS, VKOAuthUserScope::GROUPS);
        $secretKey = 'uLeeud8KcAvUE6D9B7dy';
        $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $secretKey);
        throw new Exception('Please, follow by url: ' . $browser_url . ' and enter token param after redirect.');

    }
}