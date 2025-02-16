<?php

namespace App\Http\Controllers\api;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Http\Resources\GuruRelationDataResource;
use App\Http\Resources\GuruResource;

class GuruController extends Controller
{
    public function get(Request $request)
    {
        // Get Params Search
        $search = $request->query('search');
        $dataInPage = (int) $request->query('dataInPage', 10);

        // Get Data
        $data = Guru::where('nama', 'LIKE', "%$search%")
            ->with('mataPelajaran')
            ->paginate($dataInPage);

        // Return Response With Json Resource
        return new GuruResource($data, 200, 'success', 'Data Guru With Relation Mata Pelajaran');
    }

    public function getDetail($id)
    {
        // Get Data Guru Detail
        $data = Guru::where('id', $id)->with('mataPelajaran')->first();

        // Check Data Guru is Exist
        if (!$data) {
            return response()->json(['statusCode' => 404, 'status' => 'error', 'message' => "Data Guru Not Found"], 404);
        }

        // Return Response With Json Resource
        return new GuruResource($data, 200, 'success', 'Data Detail Guru');
    }

    public function create(CreateGuruRequest $request)
    {
        // Validate Request
        $request->validated();

        // Create Guru Data
        $data = Guru::create([
            'nama' => $request->nama,
        ]);

        // Return Response With Json Resource
        return new GuruResource($data, 200, 'success', 'Success Create Data Guru');
    }

    public function update(UpdateGuruRequest $request, $id)
    {
        // Validate Data
        $request->validated();

        // Check Data Guru With ID
        $oldData = Guru::where('id', $id);
        if (!$oldData->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => "error",
                "message" => "Data Guru Not Found!",
            ], 404);
        }


        // Update Data
        $oldData->update($request->only('nama'));

        // return Response With Json Resource
        return new GuruResource(Guru::where('id', $id)->first(), 200, 'success', 'Data Guru Success Updated');
    }

    public function delete($id)
    {
        // Get Data Old
        $data = Guru::where('id', $id);

        // Check Data Guru Is Exist
        if (!$data->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Guru not Found!'
            ], 200);
        }

        // Save Res Data Remove
        $resData =  $data->first();

        // Delete Data
        $data->delete();

        // Return Response With Json Resource
        return new GuruResource($resData, 200, 'success', 'Data Guru Success Deleted!');
    }

    public function getGuruRelationData(Request $request)
    {
        // Get Param Query
        $search = $request->query('search');

        // Get Data
        $data = Guru::with('mataPelajaran', 'guruKelas', 'guruKelas.kelas', 'guruKelas.kelas.siswa')
            ->orWhere('nama', 'LIKE', '%' . $search . '%')
            ->orWhereHas('mataPelajaran', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })->orWhereHas('guruKelas.kelas', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })->orWhereHas('guruKelas.kelas.siswa', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);


        // Return Response with Json Resource
        return new GuruRelationDataResource($data, 200, 'success', 'Data Relation Guru');
    }
}
