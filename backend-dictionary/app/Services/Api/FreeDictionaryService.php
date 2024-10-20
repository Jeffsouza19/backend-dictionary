<?php

namespace App\Services\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FreeDictionaryService
{

    /**
     * @throws GuzzleException
     */
    public function getDictionaryWord(string $word)
    {
        $uri = "https://api.dictionaryapi.dev/api/v2/entries/en/" . $word;

        $http = new Client();
        $word = $http->get($uri)->getBody()->getContents();

        return json_decode($word);
    }
}
