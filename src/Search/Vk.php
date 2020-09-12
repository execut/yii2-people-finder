<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Search;

use execut\peopleFinder\Person\Person;
use execut\peopleFinder\Person\Simple;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiAuthException;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use yii\base\Exception;

class Vk implements Search
{
    protected $query = null;
    protected $currentProfileKey = 0;
    protected ?string $accessToken = null;
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function next(): bool
    {
        $this->currentProfileKey++;
    }

    public function getTotalCount(): int {
        $data = $this->getData();
        return $data['count'];
    }

    public function current():Person {
        $data = $this->getData();
        $peopleData = $data['items'][$this->currentProfileKey];
        $id = $peopleData['id'];
        $name = $peopleData['first_name'] . ' ' . $peopleData['last_name'];
        $location = null;
        if (!empty($peopleData['city'])) {
            $location .= $peopleData['city']['title'];
        }

        if (!empty($peopleData['country'])) {
            if (!empty($peopleData['city'])) {
                $location .= ', ';
            }

            $location .= $peopleData['country']['title'];
        }

        $people = new Simple($id, new \execut\peopleFinder\Name\Simple($name));
        return $people;
    }

    protected function getData() {


        $vk = new VKApiClient();
        for ($key = 0; $key < 2; $key++) {
            try {
                $token = getenv('VK_ACCESS_TOKEN');
                if (!$token) {
                    $this->requestAccessToken();
                }

                $response = $vk->users()->search($token, array(
                    'q' => $this->query,
                    'count' => 1000,
                    'fields' => 'bdate, city, country',
                ));
                break;
            } catch (VKApiAuthException $e) {
                $this->requestAccessToken();
            }
        }

        return $response;
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