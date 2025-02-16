<?php

namespace App\Http\Resources;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
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
        // Jika data adalah pagination (LengthAwarePaginator)
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

        // Jika data adalah object model biasa
        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ]
        ];
    }

    /**
     * Data Mapping
     */
    private function mapData($kelas)
    {
        return [
            'id' => $kelas->id,
            'nama' => $kelas->nama,
            'createdAt' => $kelas->created_at,
            'updatedAt' => $kelas->updated_at,
        ];
    }
}
