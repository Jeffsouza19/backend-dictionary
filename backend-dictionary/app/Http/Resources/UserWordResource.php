<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWordResource extends JsonResource
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

        $histories = $this->organizeHistory($data['data']);
        return [
            "results" => $histories,
            "totalDocs" => $this->resource['count'],
            "previous" => $data['prev_cursor'],
            "next" => $data['next_cursor'],
            "hasNext" => (bool)$data['next_cursor'],
            "hasPrev" => (bool)$data['prev_cursor'],
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setStatusCode(200);
        !empty($this->resource['cache']) ? $response->header('x-cache', 'HIT') : $response->header('x-cache', 'MISS');
    }

    public function organizeHistory($data): array
    {
        $res = [];
        foreach ($data as $each) {
            $res[] = [
                'word' => $each['word']['word'],
                'added' => $each['created_at'],
            ];
        }

        return $res;
    }
}
