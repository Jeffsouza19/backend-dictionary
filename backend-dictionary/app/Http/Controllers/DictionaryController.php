<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Resources\ListWordsPaginateResource;
use App\Http\Resources\ShowWordResource;
use App\Services\DictionaryService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class DictionaryController extends Controller
{
    /**
     * @param DictionaryService $dictionaryService
     * @return ListWordsPaginateResource
     * @throws GeneralJsonException
     */
    public function list(DictionaryService $dictionaryService): ListWordsPaginateResource
    {
        try {
            return new ListWordsPaginateResource($dictionaryService->getWords());
        }catch (\Exception $e){
            throw new GeneralJsonException($e->getMessage(), min($e->getCode(), 500));
        }
    }

    /**
     * @param DictionaryService $dictionaryService
     * @param string $word
     * @return ShowWordResource
     * @throws GeneralJsonException
     */
    public function view(DictionaryService $dictionaryService, string $word): ShowWordResource
    {
        try {
            return new ShowWordResource($dictionaryService->getWord($word));
        }catch (GuzzleException $e) {
            throw new GeneralJsonException($e->getResponse()->getBody()->getContents(), min($e->getCode(), 500), true);
        }catch (\Exception $e){
            throw new GeneralJsonException($e->getMessage(), min($e->getCode(), 500));
        }
    }

    /**
     * @param DictionaryService $dictionaryService
     * @param string $word
     * @return JsonResponse
     * @throws GeneralJsonException
     */
    public function favorite(DictionaryService $dictionaryService, string $word): JsonResponse
    {
        try {
            return response()->json($dictionaryService->setFavoriteWord($word));
        }catch (\Exception $e){
            throw new GeneralJsonException($e->getMessage(), min($e->getCode(), 500));
        }
    }

    /**
     * @param DictionaryService $dictionaryService
     * @param string $word
     * @return JsonResponse
     * @throws GeneralJsonException
     */
    public function unfavorite(DictionaryService $dictionaryService, string $word): JsonResponse
    {
        try {
            return response()->json($dictionaryService->removeFavoriteWord($word));
        }catch (\Exception $e){
            throw new GeneralJsonException($e->getMessage(), min($e->getCode(), 500));
        }
    }
}
