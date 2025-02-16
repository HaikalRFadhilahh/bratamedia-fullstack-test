<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuruKelasRequest;
use App\Http\Requests\UpdateGuruKelasRequest;
use App\Http\Resources\GuruKelasResource;
use App\Models\GuruKelas;
use Illuminate\Http\Request;

class GuruKelasController extends Controller
{
    public function get(Request $request)
    {
        // Get Query Search
        $search = $request->query('search');

        // Get Data From Database
        $data = GuruKelas::with('kelas', 'guru')
            ->whereHas('kelas', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('guru', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        // Return Response With Json Resource
        return new GuruKelasResource($data, 200, 'success', 'Data Guru and Kelas Relation');
    }

    public function getDetail($id)
    {
        // Validate Data
        $data = GuruKelas::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Relation Guru and Kelas Not Found!'
            ], 404);
        }

        // Return Response With Json Resource
        return new GuruKelasResource($data, 200, 'success', 'Data Guru and Kelas Relation Detail');
    }

    public function create(CreateGuruKelasRequest $request)
    {
        // Validate Request
        $request->validated();

        // Create Data Guru Kelas
        $data = GuruKelas::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => $request->guru_id
        ]);

        //
        return new GuruKelasResource($data, 200, 'success', 'Success Create Data Guru Kelas');
    }

    public function update(UpdateGuruKelasRequest $request, $id)
    {
        // Validate Data
        $request->validated();

        // Check Data
        $data = GuruKelas::where('id', $id);
        if (!$data->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Guru and Kelas Not Found!'
            ], 404);
        }

        // Update Data
        $data->update($request->only('guru_id', 'kelas_id'));

        // Return Response With Json Resource
        return new GuruKelasResource(GuruKelas::where('id', $id)->with('kelas', 'guru')->first(), 200, 'success', 'Data Guru and Kelas Relation');
    }

    public function delete($id)
    {
        // Validate Data
        $data = GuruKelas::where('id', $id);
        if (!$data->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Guru and Kelas Not Found!'
            ], 404);
        }

        // Copy Response Data
        $resData = $data->first();

        // Delete Data
        $data->delete();

        // Return Response With Json Resource
        return new GuruKelasResource($resData, 200, 'success', 'Success Deleted Guru and Kelas Data!');
    }
}
