<?php

namespace src\Integration;

class DataProvider
{
    /** @var string */
    private $host;

    /** @var string */
    private $user;

    /** @var string */
    private $password;

    /**
     * @param DataConfig $config
     */
    public function __construct(DataConfig $config)
    {
        $this->host = $config->host ?? '';
        $this->user = $config->user ?? '';
        $this->password = $config->password ?? '';
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request)
    {
        // returns a response from external service
    }
}
