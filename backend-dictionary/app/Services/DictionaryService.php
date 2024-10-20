<?php

namespace App\Services;

use App\Repositories\Interfaces\Word\WordInterface;
use App\Services\Api\FreeDictionaryService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class DictionaryService
{
    protected WordInterface $repo;

    public function __construct(WordInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getWords()
    {
        return $this->repo->getAll();

    }

    /**
     * @throws GuzzleException
     */
    public function getWord(string $word)
    {
        $cachedWord = Cache::get($word);

//        if ($cachedWord){
//            return $cachedWord;
//        }

        $apiService = new FreeDictionaryService();
        $newWord = null;
        $data = $this->repo->getOne($word);

        if (!$data || count($data->phonetics()->get()) == 0) {
            $newWord = $apiService->getDictionaryWord($word);
        }
dd($newWord);
        if ($newWord){
            $data = $this->repo->createWord($data, $newWord);
        }



//        Cache::put($word, $newWord);
        return $data;
    }

    protected function organizeWords($arrWords)
    {
        $newWord = [];
        foreach ($arrWords as $each) {
            $data = $this->objectToArray($each);
            $newWord['word'] = $each->word;
            $newWord['phonetic'] = $each->phonetic;
            foreach ($each->phonetics as $k => $each_phonetic) {
                $newWord['phonetics'][$k] = [
                    'text' => $each_phonetic->text,
                    'audio' => $each_phonetic->audio,
                    'sourceUrl' => $each_phonetic->sourceUrl,
                    'license' => [
                        'name' => $each_phonetic->license->name,
                        'url' => $each_phonetic->license->url,
                    ],
                ];
            }
            foreach ($each->meanings as $k => $each_meaning) {
                $newWord['meanings'][$k] = [
                    'partOfSpeech' => $each_meaning->partOfSpeech,
                    'definition' => []
                ];
                foreach ($each_meaning->definitions as $each_meaningDefinition) {

                    $newWord['meanings'][$k]['definitions'][] = [
                        'definition' => $each_meaningDefinition->definition,
                        'synonyms' => [],
                        'antonyms' => [],
                        'example' => $each_meaningDefinition->example ?? null,
                    ];
//                    dd($newWord, $each_meaningDefinition, $each_meaning, $each_meaningDefinition);
                }

//                dd($each_meaning);
            }
//            dd($each, $newWord);
        }
        dd($arrWords, $newWord);
    }

}

