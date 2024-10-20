<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListWordsPaginateResource extends JsonResource
{

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource['paginate']->toArray();
        $words = $this->organizeWords($data['data']);
        return [
            "results" => $words,
            "totalDocs" => $this->resource['count'],
            "previous" => $data['prev_cursor'],
            "next" => $data['next_cursor'],
            "hasNext" => (bool)$data['next_cursor'],
            "hasPrev" => (bool)$data['prev_cursor'],
        ];
    }

    protected function organizeWords($arrWords)
    {
        $words = [];
        foreach ($arrWords as $word) {
            $words[] = $word['word'];

        }
        return $words;
    }
}
