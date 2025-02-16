<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class MataPelajaranResource extends JsonResource
{
    private $statusCode;
    private $status;
    private $message;

    public function __construct($resource, $sc = 200, $s = "success", $m = "Data Kelas")
    {
        Parent::__construct($resource);
        $this->statusCode = $sc;
        $this->status = $s;
        $this->message = $m;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Paginate Mapping
        if ($this->resource instanceof LengthAwarePaginator) {
            return [
                'statusCode' => $this->statusCode,
                'status' => $this->status,
                'message' => $this->message,
                'data' => $this->resource->map(fn($item) => $this->mapData($item))->toArray(),
                'pagination' => [
                    'totalData' => $this->resource->total(),
                    'dataInPage' => $this->resource->perPage(),
                    'currentPage' => $this->resource->currentPage(),
                    'totalPage' => $this->resource->lastPage()
                ]
            ];
        }

        // Non Paginate Data
        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'guruId' => $this->guru_id,
                'guru' => $this->mapDataGuru($this->guru),
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ]
        ];
    }

    private function mapData($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'guruId' => $items->guru_id,
            'guru' => $this->mapDataGuru($items->guru),
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function mapDataGuru($i)
    {
        return [
            'id' => $i->id,
            'nama' => $i->nama,
            'createdAt' => $i->created_at,
            'updatedAt' => $i->updated_at,
        ];
    }
}
