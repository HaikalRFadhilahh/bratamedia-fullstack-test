<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class GuruResource extends JsonResource
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
        // Mapping Data IF Pagination
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

        // Map If Data Array Not Pagination
        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'mataPelajaran' => $this->mataPelajaran->map(fn($i) => $this->mapMataPelajaran($i))->toArray(),
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ]
        ];
    }

    /*
        Mapping Data
    */

    private function mapData($item)
    {
        return [
            'id' => $item->id,
            'nama' => $item->nama,
            'mataPelajaran' => $item->mataPelajaran->map(fn($i) => $this->mapMataPelajaran($i))->toArray(),
            'createdAt' => $item->created_at,
            'updatedAt' => $item->updated_at,
        ];
    }

    /*
        Map Data For Relation Mata Pelajaran
    */
    private function mapMataPelajaran($item)
    {
        return [
            'id' => $item->id,
            'nama' => $item->nama,
            'guruId' => $item->guru_id,
            'createdAt' => $item->created_at,
            'updatedAt' => $item->updated_at,
        ];
    }
}
