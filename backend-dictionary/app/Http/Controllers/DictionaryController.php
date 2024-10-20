<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Resources\ListWordsPaginateResource;
use App\Http\Resources\ShowWordResource;
use App\Services\DictionaryService;
use GuzzleHttp\Exception\GuzzleException;

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
     * @throws GeneralJsonException
     */
    public function view(DictionaryService $dictionaryService, string $wordId): ShowWordResource
    {
        try {
            return new ShowWordResource($dictionaryService->getWord($wordId));
        }catch (\Exception $e){
            throw new GeneralJsonException($e->getMessage(), min($e->getCode(), 500));
        } catch (GuzzleException $e) {
            throw new GeneralJsonException($e->getMessage(), min($e->getCode(), 500));
        }
    }
}
