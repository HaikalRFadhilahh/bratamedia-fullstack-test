<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruRelationDataResource extends JsonResource
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
        return $this->responseData($this->resource);
    }

    private function responseData($items)
    {
        return [
            'statusCode' => $this->statusCode,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $items->map(fn($items) => $this->guru($items))->toArray(),
            'pagination' => [
                'totalData' => $items->total(),
                'dataInPage' => $items->perPage(),
                'currentPage' => $items->currentPage(),
                'totalPage' => $items->lastPage()
            ]
        ];
    }

    private function guru($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'mataPelajaran' => $items->mataPelajaran->map(fn($items) => $this->mataPelajaran($items))->toArray(),
            'kelas' => $items->guruKelas->map(fn($items) => $this->kelas($items))->toArray(),
            'siswa' => $items->guruKelas->flatMap(fn($i) => $i->kelas->siswa ?? [])->map(fn($i) => $this->siswa($i))->unique('id')->values()->toArray(),
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function mataPelajaran($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'guruId' => $items->guru_id,
            'createdAt' => $items->created_at,
            'updatedAt' => $items->updated_at
        ];
    }

    private function kelas($items)
    {
        return [
            'id' => $items->kelas->id,
            'nama' => $items->kelas->nama,
            'createdAt' => $items->kelas->created_at,
            'updatedAt' => $items->kelas->updated_at
        ];
    }

    private function siswa($items)
    {
        return [
            'id' => $items->id,
            'nama' => $items->nama,
            'umur' => $items->umur,
            'kelasId' => $items->kelas_id,
            'createdAt' => $items->kelas->created_at,
            'updatedAt' => $items->kelas->updated_at
        ];
    }
}
