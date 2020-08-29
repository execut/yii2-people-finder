<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peoplesFinder\odnoklassniki;


use yii\base\Exception;

class Identity
{
    protected ?string $authcode;
    protected ?string $jSession;

    public function __construct(string $authcode = null, string $jSession = null) {

        $this->authcode = $authcode;

        $this->jSession = $jSession;
    }

    /**
     * @return string
     */
    public function getAuthcode(): string
    {
        if ($this->authcode === null) {
            if (!($this->authcode = getenv('ODNOKLASSNIKI_AUTHCODE'))) {
                throw new Exception('Define ODNOKLASSNIKI_AUTHCODE constant');
            }
        }

        return $this->authcode;
    }

    /**
     * @return string
     */
    public function getJSession(): string
    {
        if ($this->jSession === null) {
            if (!($this->jSession = getenv('ODNOKLASSNIKI_JSESSION'))) {
                throw new Exception('Define ODNOKLASSNIKI_JSESSION constant');
            }
       }

        return $this->jSession;
    }
}