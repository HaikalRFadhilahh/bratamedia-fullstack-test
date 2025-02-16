<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class GuruKelasResource extends JsonResource
{
    /*
        PRIVATE ATRRIBUTE
    */

    private $statusCode;
    private $status;
    private $message;

    /*
        CONSTRUCTOR
    */
    public function __construct($resource, $sc = 200, $s = 'success', $m = "")
    {
        parent::__construct($resource);
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

        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->mapData($this->resource)
        ];
    }

    /*
        MAPPING Data
    */
    private function mapData($items)
    {
        return [
            'id' => $items->id,
            'kelasId' => $items->kelas_id,
            'guruId' => $items->guru_id,
            'kelas' => $this->getKelas($items->kelas),
            'guru' => $this->getGuru($items->guru),
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function getGuru($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function getKelas($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }
}
