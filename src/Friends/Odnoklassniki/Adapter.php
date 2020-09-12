<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Friends\Odnoklassniki;


use execut\peopleFinder\Odnoklassniki\Identity;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use yii\base\Exception;

class Adapter
{
    protected $cache = null;
    protected Identity $identity;
    protected $lastRequestTime = null;
    public function __construct($cache = null) {
        if ($cache === null) {
            $cache = \yii::$app->cache;
        }

        $this->identity = new Identity();

        $this->cache = $cache;
    }
    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFriendsHtml($userId, $pageNbr, $sleepSeconds = 0.5): string
    {
        $cache = $this->cache;
        $cacheKey = __CLASS__ . $userId . ' -   ' . $pageNbr;
        if (!$cache || $cache && ($string = $cache->get($cacheKey)) === false) {
            usleep($sleepSeconds * 1000000);
            $client = $this->getGuzzleClient();
            $uri = new Uri('https://ok.ru/dk?st.cmd=friendFriend&st.friendId=' . $userId . '&cmd=FriendsPageMRB');
            $form = [
                'fetch' => 'false',
                'st.page' => $pageNbr,
                'gwt.requested' => '79fb1541T1598449461701',
            ];
            $request = new Request('POST', $uri);
            $cookie = CookieJar::fromArray([
                'AUTHCODE' => $this->getAuthCode(),
                'JSESSIONID' => $this->getJSession(),
            ], 'ok.ru');
            $response = $client->send($request, [
                'form_params' => $form,
                'cookie' => $cookie,
            ]);
            $stream = $response->getBody();
            $string = $stream->getContents();
            if ($response->getHeader('Redirect-Location')) {
                $redirectLocation = $response->getHeader('Redirect-Location')[0];
                if (strpos($redirectLocation, 'FRIENDS_VISIBILITY') !== false) {
                } else {
                    throw new Exception('Wrong token because redirect to ' . $redirectLocation);
                }
            }

            if ($cache) {
                $cache->set($cacheKey, $string);
            }
        }

        return $string;
    }

    protected function getAuthCode() {
        return $this->identity->getAuthcode();
    }

    /**
     * @return string
     */
    protected function getJSession(): string
    {
        return $this->identity->getJSession();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function getGuzzleClient(): \GuzzleHttp\Client
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://ok.ru/',
            'allow_redirects' => false,
//            'debug' => 1,
        ]);
        return $client;
    }
}