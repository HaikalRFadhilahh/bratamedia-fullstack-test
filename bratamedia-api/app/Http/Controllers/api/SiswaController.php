<?php

namespace App\Http\Controllers\api;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Http\Resources\SiswaResource;

class SiswaController extends Controller
{
    public function get(Request $request)
    {
        // Take Query Data
        $search = $request->query('search');
        $dataInPage = (int) $request->query('dataInPage', 10);

        // Get Data Siswa
        $data = Siswa::where('nama', 'LIKE', '%' . $search . '%')
            ->with('kelas')
            ->paginate($dataInPage);


        // Return Json Data With JsonResource
        return new SiswaResource($data, 200, 'success', 'Data Siswa');
    }

    public function getDetail($id)
    {
        // Check Data
        $data = Siswa::where('id', $id)
            ->with('kelas')
            ->first();

        if (!$data) {
            return response()->json(['statusCode' => 404, 'status' => "error", 'message' => "Data Siswa Not Found!"], 404);
        }

        // Return data With Json Resource
        return new SiswaResource($data, 200, 'success', 'Data Detail Siswa');
    }

    public function create(CreateSiswaRequest $request)
    {
        // Validate Request
        $request->validated();

        // Action Create
        $data = Siswa::create([
            'nama' => $request->nama,
            'umur' => $request->umur,
            'kelas_id' => $request->kelas_id
        ]);


        // Response Json Data
        return new SiswaResource($data, 200, 'success', 'Data Siswa Success Created');
    }

    public function update(UpdateSiswaRequest $request, $id)
    {
        // Validate Request
        $request->validated();

        // Check Existing Siswa Data
        if (!Siswa::where('id', $id)->first()) {
            return response()->json(['statusCode' => 404, 'status' => 'success', 'message' => 'Data Siswa Not Found'], 404);
        }

        // Update Data
        Siswa::where('id', $id)->update($request->only('nama', 'umur', 'kelas_id'));

        // Return Response Json
        return new SiswaResource(Siswa::where('id', $id)->with('kelas')->first(), 200, 'success', 'Data Siswa Success Updated');
    }

    public function delete($id)
    {
        // Validate Data
        $dataSiswa = Siswa::where('id', $id)->with('kelas');
        $resData = $dataSiswa->first();

        // Check Data
        if (!$dataSiswa->first()) {
            return response()->json(['statusCode' => 404, 'status' => 'error', 'message' => "Data Not Found!"], 404);
        }

        // Delete Data
        $dataSiswa->delete();

        // Return Response
        return new SiswaResource($resData, 200, 'success', 'Data Siswa Success Deleted!');
    }
}
