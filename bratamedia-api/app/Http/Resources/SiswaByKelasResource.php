<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaByKelasResource extends JsonResource
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
        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource->map(fn($i) => $this->showData($i))->toArray(),
            'pagination' => [
                'totalData' => $this->resource->total(),
                'dataInPage' => $this->resource->perPage(),
                'currentPage' => $this->resource->currentPage(),
                'totalPage' => $this->resource->lastPage()
            ]
        ];
    }

    private function showData($items)
    {
        return  [
            'id' => $items->id,
            'nama' => $items->nama,
            'siswa' => $items->siswa->map(fn($i) => $this->getSiswa($i))->toArray(),
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function getSiswa($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'umur' => $items->umur,
            'kelasId' => $items->kelas_id,
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at,
        ];
    }
}
