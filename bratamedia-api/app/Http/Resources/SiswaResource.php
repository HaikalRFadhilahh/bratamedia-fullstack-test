<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class SiswaResource extends JsonResource
{
    /*
        PRIVATE ATRIBUTE
    */

    private $statusCode;
    private $status;
    private $message;

    /*
        CONSTRUCTOR
    */
    public function __construct($resource, $sc = 200, $s = 'success', $m = '')
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
        // Jika data adalah pagination
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
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'umur' => $this->umur,
                'kelasId' => $this->kelas_id,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
                'kelas' => [
                    'id' => $this->kelas->id,
                    'nama' => $this->kelas->nama,
                    'createdAt' => $this->kelas->created_at,
                    'updatedAt' => $this->kelas->updated_at,
                ],
            ]
        ];
    }

    private function mapData($item)
    {
        return [
            'id' => $item->id,
            'nama' => $item->nama,
            'umur' => $item->umur,
            'kelasId' => $item->kelas_id,
            'createdAt' => $item->created_at,
            'updatedAt' => $item->updated_at,
            'kelas' => [
                'id' => $item->kelas->id,
                'nama' => $item->kelas->nama,
                'createdAt' => $item->kelas->created_at,
                'updatedAt' => $item->kelas->updated_at,
            ],

        ];
    }
}
