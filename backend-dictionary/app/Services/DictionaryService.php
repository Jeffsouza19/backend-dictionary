<?php

namespace App\Services;

use App\Repositories\Interfaces\User\UserFavoriteInterface;
use App\Repositories\Interfaces\Word\WordInterface;
use App\Services\Api\FreeDictionaryService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class DictionaryService
{
    protected WordInterface $repo;
    protected UserFavoriteInterface $userFavoriteRepo;

    public function __construct(WordInterface $repo, UserFavoriteInterface $userFavorite)
    {
        $this->repo = $repo;
        $this->userFavoriteRepo = $userFavorite;
    }

    public function getWords()
    {
        $req = request()->only('search', 'limit');
        return $this->repo->getAll($req['search'], $req['limit']??20);

    }

    /**
     * @throws GuzzleException
     */
    public function getWord(string $word)
    {
        $cachedWord = Cache::get($word);

        if ($cachedWord){
            return $cachedWord;
        }

        $newWord = null;
        $data = $this->repo->getOne($word);

        if (!$data || count($data->phonetics()->get()) == 0) {
            $apiService = new FreeDictionaryService();
            $newWord = $apiService->getDictionaryWord($word);
        }

        if ($newWord){
            $data = $this->repo->createWord($data, $newWord);
        }

        $wordDefinition = $this->organizeWords($data);

        Cache::put($word, $wordDefinition, 60);
        return $wordDefinition;
    }

    public function setFavoriteWord(string $word)
    {
        $user = auth()->user();
        $objWord = $this->repo->getOne($word);
        $res = $this->userFavoriteRepo->setFavorite($user, $objWord);

        return [
            'word' => $objWord['word'],
            'added' => $res['created_at'],
        ];
    }

    public function removeFavoriteWord(string $word)
    {
        $user = auth()->user();
        $objWord = $this->repo->getOne($word);
        $res = $this->userFavoriteRepo->destroy($user, $objWord);

        return [];
    }

    protected function organizeWords($word): array
    {
        $wordPhonetics = $word->phonetics()->get();
        foreach ($wordPhonetics as $wordPhonetic) {
            $wordPhonetic['license'] = $wordPhonetic->licenses()->get()->toArray();
        }

        $wordMeanings = $word->meanings()->get();
        foreach ($wordMeanings as $k => $wordMeaning) {
            $wordMeaningDefinitions = $wordMeaning->definitions()->get();
            $wordMeanings[$k]['definition'] = $wordMeaning->definitions()->get();
            $synonyms = $wordMeaning->synonyms()->get()->toArray();
            $antonyms = $wordMeaning->antonyms()->get()->toArray();

            foreach ($synonyms as $i => $synonym) {
                $wordMeanings[$k]['synonyms'][$i] = $synonym['synonym'];
            }

            foreach ($antonyms as $i => $antonym) {
                $wordMeanings[$k]['antonyms'][$i] = $antonym['antonym'];
            }

            foreach ($wordMeaningDefinitions as $i => $wordMeaningDefinition) {

                $defiSynonyms = $wordMeaningDefinition->synonyms()->get()->toArray();
                $defiAntonyms = $wordMeaningDefinition->antonyms()->get()->toArray();
                $resAntonyms = [];
                $resSynonyms = [];
                foreach ($defiAntonyms as $defiAntonym) {
                    $resAntonyms[] = $defiAntonym['antonym'];
                }
                foreach ($defiSynonyms as $defiSynonym) {
                    $resSynonyms[] = $defiSynonym['synonym'];
                }

                $wordMeanings[$k]['definition'][$i]['synonyms'] = $resSynonyms;
                $wordMeanings[$k]['definition'][$i]['antonyms'] = $resAntonyms;

            }

        }

        $wordLicenses = $word->licenses()->get()->toArray();

        return [
            'word' => $word['word'],
            'phonetic' => $word['phonetic'],
            'phonetics' => $wordPhonetics->toArray(),
            'meanings' => $wordMeanings->toArray(),
            'license' => $wordLicenses,

        ];
    }

}

