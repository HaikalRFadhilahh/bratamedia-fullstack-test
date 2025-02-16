<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruByKelasResource extends JsonResource
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
        return $this->responseData($this->resource);
    }

    /*
        MAPPING DATA
    */
    private function responseData($items)
    {
        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $items->map(fn($i) => $this->kelas($i))->toArray(),
            'pagination' => [
                'totalData' => $items->total(),
                'dataInPage' => $items->perPage(),
                'currentPage' => $items->currentPage(),
                'totalPage' => $items->lastPage()
            ]
        ];
    }

    private function kelas($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'guru' => $items->guruKelas->map(fn($i) => $this->guru($i))->toArray(),
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function guru($items)
    {
        return [
            'id' => $items->guru->id,
            'nama' => $items->guru->nama,
            'createdAt' => $items->guru->created_at,
            'updatedAt' => $items->guru->updated_at
        ];
    }
}
