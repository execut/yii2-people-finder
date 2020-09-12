<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Search\Odnoklassniki;


use execut\peopleFinder\Odnoklassniki\Identity;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use yii\base\Exception;
use yii\helpers\Json;

class Adapter
{

    protected Identity $identity;
    protected $cache = null;
    public function __construct($cache = null) {
        if ($cache === null) {
            $cache = \yii::$app->cache;
        }

        $this->identity = new Identity();

        $this->cache = $cache;
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
     * @param int $firstIndex
     * @param string $query
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getValues(int $firstIndex, string $query, int $pageSize)
    {
        $cache = $this->cache;
        $cacheKey = __CLASS__ . '-' . $firstIndex . '- ' . $query;
        if (!$cache || $cache && ($value = $cache->get($cacheKey)) === false) {
            $client = $this->getGuzzleClient();
            $uri = new Uri('https://ok.ru/web-api/v2/search/portal');
            $parameters = Json::decode('{"id":2,"parameters":{"chunk":{"count":' . $pageSize . ',"firstIndex":' . $firstIndex . ',"offset":0},"filters":{"st.cmd":"searchResult","st.mode":"Users","st.query":"' . $query . '"},"query":"' . $query . '"}}');
            $request = new Request('POST', $uri);
            $cookie = CookieJar::fromArray([
                'AUTHCODE' => $this->getAuthCode(),
                'JSESSIONID' => $this->getJSession(),
            ], 'ok.ru');
            $response = $client->send($request, [
                'json' => $parameters,
                'cookies' => $cookie,
            ]);
            $stream = $response->getBody();
            $string = $stream->getContents();
            $value = Json::decode($string);
            if (empty($value)) {
                throw new Exception('Returned value is not array: ' . var_export($value, true) . ', as string: ' . var_export($string, true));
            }

            if (empty($value['success'])) {
                throw new Exception('Response error: ' . var_export($value, true) . ', as string: ' . var_export($string, true));
            }

            if ($cache) {
                $cache->set($cacheKey, $value);
            }
        }
        return $value;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getGuzzleClient(): \GuzzleHttp\Client
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://ok.ru/',
//            'debug' => 1,
        ]);
        return $client;
    }
}