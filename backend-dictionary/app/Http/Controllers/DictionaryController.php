<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\ListWordsPaginateResource;
use App\Http\Resources\ShowWordResource;
use App\Services\DictionaryService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

/**
 * @group Dictionary Routes
 */
class DictionaryController extends Controller
{
    /**
     * List Words Route
     *
     * @param DictionaryService $dictionaryService
     * @return ListWordsPaginateResource
     * @throws GeneralJsonException
     * @response 200 { "results": [ "histoblast", "histochemic", "histochemical" ], "totalDocs": 117, "previous": null, "next": "eyJ3b3JkIjoiaGlzdG9jaGVtaWNhbCIsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0", "hasNext": true, "hasPrev": false }
     * @queryParam limit int Limit words to search
     * @queryParam search string Search words
     * @response 400 { "errors": { "message": "An error occurred while retrieving list of words." } }
     */
    public function list(DictionaryService $dictionaryService): ListWordsPaginateResource
    {
        try {
            return new ListWordsPaginateResource($dictionaryService->getWords());
        }catch (\Exception $e){
            throw new GeneralJsonException('An error occurred while retrieving list of words.');
        }
    }

    /**
     * View Word definitions Route
     *
     * @param DictionaryService $dictionaryService
     * @param string $word
     * @return ShowWordResource
     * @throws GeneralJsonException
     * @response 200 { "word": "hi", "phonetic": "/haɪ/", "phonetics": [ { "text": "/haɪ/", "audio": "https://api.dictionaryapi.dev/media/pronunciations/en/hi-1-uk.mp3", "sourceUrl": "https://commons.wikimedia.org/w/index.php?curid=9021999", "license": [ { "name": "BY 3.0 US", "url": "https://creativecommons.org/licenses/by/3.0/us" } ] }, ], "meanings": [ { "partOfSpeech": "noun", "definition": [ { "definition": "The word \"hi\" used as a greeting.", "example": "I didn't even get a hi.", "synonyms": [], "antonyms": [] } ], "synonyms": [ "greeting", "hello" ] } ], "license": [ { "id": 18, "word_id": 138128, "name": "CC BY-SA 3.0", "url": "https://creativecommons.org/licenses/by-sa/3.0", "created_at": "2024-10-20T16:20:36.000000Z", "updated_at": "2024-10-20T16:20:36.000000Z" }, { "id": 19, "word_id": 138128, "name": "CC BY-SA 3.0", "url": "https://creativecommons.org/licenses/by-sa/3.0", "created_at": "2024-10-20T16:20:36.000000Z", "updated_at": "2024-10-20T16:20:36.000000Z" } ] }
     * @response 400 { "errors": { "message": { "title": "No Definitions Found", "message": "Sorry pal, we couldn't find definitions for the word you were looking for.", "resolution": "You can try the search again at later time or head to the web instead." } } }
     */
    public function view(DictionaryService $dictionaryService, string $word): ShowWordResource
    {
        try {
            return new ShowWordResource($dictionaryService->getWord($word));
        }catch (GuzzleException $e) {
            throw new GeneralJsonException($e->getResponse()->getBody()->getContents(), decode: true);
        }catch (\Exception $e){
            throw new GeneralJsonException('An error occurred when searching for the word, was the word typed correctly?');
        }
    }

    /**
     * Set Favorite Word Route
     *
     * @param DictionaryService $dictionaryService
     * @param string $word
     * @return FavoriteResource
     * @throws GeneralJsonException
     * @response 200 { "word": "aa", "added": "2024-10-20T17:04:28.000000Z" }
     * @response 400 { "errors": { "message": "An error occurred while favoriting the word" } }
     */
    public function favorite(DictionaryService $dictionaryService, string $word): FavoriteResource
    {
        try {
            return new FavoriteResource($dictionaryService->setFavoriteWord($word));
        }catch (\Exception $e){
            throw new GeneralJsonException('An error occurred while favoriting the word');
        }
    }

    /**
     * Unset Favorite Word Route
     *
     * @param DictionaryService $dictionaryService
     * @param string $word
     * @return JsonResponse
     * @throws GeneralJsonException
     * @response 204
     * @response 400 { "errors": { "message": "An error occurred to unfavorite the word" } }
     */
    public function unfavorite(DictionaryService $dictionaryService, string $word): JsonResponse
    {
        try {
            return response()->json([])->setStatusCode(204);
        }catch (\Exception $e){
            throw new GeneralJsonException('An error occurred to unfavorite the word');
        }
    }
}
