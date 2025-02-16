<?php

namespace App\Http\Controllers\api;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KelasResource;
use App\Http\Requests\CreateKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Http\Resources\GuruByKelasResource;
use App\Http\Resources\SiswaByKelasResource;

class KelasController extends Controller
{
    public function create(CreateKelasRequest $request)
    {
        // Validate Request
        $request->validated();

        // Insert Data
        $res = Kelas::create([
            'nama' => $request->nama
        ]);

        // Return Response
        return new KelasResource($res, 200, "success", "Create Data Success");
    }

    public function get(Request $request)
    {
        // Ambil Search key
        $searchKey = $request->query('search') ?? "";
        $dataInPage = (int) $request->query('dataInPage', 10);


        // Ambil Data
        $data = Kelas::where('nama', 'LIKE', '%' . $searchKey . '%')
            ->paginate($dataInPage);


        // Return Response Json
        return new KelasResource($data, 200, "success", "Data Kelas");
    }

    public function update(UpdateKelasRequest $request, $id)
    {
        // Validate Request
        $request->validated();


        // Check User ID
        $oldDataKelas = Kelas::where('id', $id);
        if (!$oldDataKelas->first()) {
            return response()->json(['statusCode' => 404, 'status' => "error", "message" => "Data Kelas With ID=$id Not Found "], 404);
        }


        // Action Update
        $oldDataKelas->update($request->all());

        // Return Response
        return new KelasResource(Kelas::where('id', $id)->first(), 200, "success", "Success Update Data kelas With ID=$id");
    }

    public function delete($id)
    {
        // Check ID
        $data = Kelas::where('id', $id);
        $resData = $data->first();
        if ($data->get()->isEmpty()) {
            return response()->json(['statusCode' => 404, 'status' => 'error', 'message' => "Data Kelas Not Found!"], 404);
        }

        // Delete Data Kelas
        $data->delete();

        // Return Response
        return new KelasResource($resData, 200, 'success', "Data Kelas With ID=$id Success Deleted!");
    }

    public function getDetail($id)
    {
        // Check Users
        $data = Kelas::where('id', $id)->first();

        if (!$data) {
            return response()->json(['statusCode' => 404, 'status' => 'error', 'message' => 'Data users Not Found!'], 404);
        }

        // Return Response
        return new KelasResource($data, 200, "success", "Data Detail Kelas with ID=$id");
    }

    public function getSiswaByKelas(Request $request)
    {
        // Get Data Query param
        $search = $request->query('search');

        // Data
        $data = Kelas::with('siswa')
            ->orWhere('nama', 'LIKE', '%' . $search . '%')
            ->orWhereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);


        // Return Response With Json Resource
        return new SiswaByKelasResource($data, 200, 'success', 'Data Siswa Group By Kelas');
    }

    public function getGuruByKelas(Request $request)
    {
        // Get Query Serach
        $search = $request->query('search');

        // Get Data
        $data = Kelas::has('guruKelas')
            ->with('guruKelas', 'guruKelas.guru')
            ->orWhere('nama', 'LIKE', '%' . $search . '%')
            ->orWhereHas('guruKelas.guru', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        // Return Response With Json Resource
        return new GuruByKelasResource($data, 200, 'success', 'Data Guru By Kelas');
    }
}
