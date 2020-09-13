<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\NamesNormalizer;


class Normalizer
{
    protected $nameVsSynonyms = null;
    protected $synonymsVsNames = [];
    protected $normalNames = [];
    public function normalize($name): ?string
    {
        $this->loadData();
        $name = $this->normalizeString($name);
        if (isset($this->nameVsSynonyms[$name])) {
            return $this->normalNames[$name];
        }

        if (isset($this->synonymsVsNames[$name])) {
            return $this->normalNames[$this->synonymsVsNames[$name]];
        }

        $this->logBadName($name);

        return null;
    }

    protected $alreadyLogged = null;
    protected function logBadName($name)
    {
        $logFile = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'bad-names.txt';
        if ($this->alreadyLogged === null) {
            if (file_exists($logFile)) {
                $string = file_get_contents($logFile);
                $parts = explode("\n", $string);
                $this->alreadyLogged = [];
                foreach ($parts as $part) {
                    $this->alreadyLogged[$part] = true;
                }
            }
        }

        if (empty($this->alreadyLogged[$name])) {
            $this->alreadyLogged[$name] = true;
            $fp = fopen($logFile, 'a+');
            fwrite($fp, $name . "\n");
            fclose($fp);
        }
    }

    protected function loadData()
    {
        if ($this->nameVsSynonyms !== null) {
            return;
        }

        $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'zhuharev_synonym_name.txt');
        $lines = explode("\n", $content);
        $nameVsSynonyms = [];
        $synonymsVsNames = [];
        foreach ($lines as $line) {
            $parts = explode('-', $line);
            $sourceName = trim($parts[0], ' -');
            $normalName = $this->normalizeString($sourceName);
            $this->normalNames[$normalName] = $sourceName;
            $synonyms = [];
            $synonymsParts = explode(',', $parts[1]);
            foreach ($synonymsParts as $part) {
                $synonymSource = trim($part, ' ');
                $synonym = $this->normalizeString($synonymSource);
                $this->normalNames[$synonym] = $synonymSource;
                $synonymsVsNames[$synonym] = $normalName;
                $synonyms[$synonym] = $synonym;
            }

            $nameVsSynonyms[$normalName] = $synonyms;
        }

        $this->synonymsVsNames = $synonymsVsNames;
        $this->nameVsSynonyms = $nameVsSynonyms;
    }

    protected function normalizeString(string $string)
    {
        $string = $this->toLowerCase($string);

        return str_replace('ё', 'е', $string);
    }

    protected function toLowerCase(string $string): string
    {
        return mb_strtolower($string);
    }
}