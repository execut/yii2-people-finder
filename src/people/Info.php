<?php
/**
 */

namespace execut\peoplesFinder\people;

class Info
{
    protected ?int $age;
    protected ?string $countryName;
    protected ?string $cityName;
    public function __construct(int $age = null, string $countryName = null, string $cityName = null) {
        $this->age = $age;
        $this->countryName = $countryName;
        $this->cityName = $cityName;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @return string|null
     */
    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    /**
     * @return string|null
     */
    public function getCountryName(): ?string
    {
        return $this->countryName;
    }
}