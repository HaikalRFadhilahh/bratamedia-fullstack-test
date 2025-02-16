<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Http\Resources\MataPelajaranResource;

class MataPelajaranController extends Controller
{
    public function get(Request $request)
    {
        // Get Search Query From Request
        $search = $request->query('search') ?? "";

        // Get Data
        $data = MataPelajaran::where('nama', 'LIKE', '%' . $search . '%')
            ->orWhereHas('guru', function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%');
            })
            ->with('guru')
            ->paginate(10);

        // dd($data);
        // Return Response With Json Resource
        return new MataPelajaranResource($data, 200, 'success', 'Data Mata Pelajaran');
    }

    public function getDetail($id)
    {
        // Get Data
        $data = MataPelajaran::where('id', $id)->with('guru');

        // Check Data Mata Pelajaran
        if (!$data->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Mata Pelajaran Not Found!'
            ], 404);
        }


        // Return Data
        return new MataPelajaranResource($data->first(), 200, 'success', 'Data Detail Users');
    }

    public function create(CreateMataPelajaranRequest $request)
    {
        // Validate Request
        $request->validated();

        // Create Data
        $data = MataPelajaran::create([
            'nama' => $request->nama,
            'guru_id' => $request->guru_id
        ]);

        // Return Response Json Resource
        return new MataPelajaranResource($data, 200, 'success', 'Success Create Data Mata Pelajaran');
    }

    public function update(UpdateMataPelajaranRequest $request, $id)
    {
        // Check data Mata Pelajaran
        $data = MataPelajaran::where('id', $id);
        if (!$data->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Mata Pelajaran Not Found!'
            ], 404);
        }

        // Validation Request
        $request->validated();

        // Update Data Mata Pelajaran
        $data->update($request->only('nama', 'guru_id'));

        // Return Response Json Resource
        return new MataPelajaranResource(MataPelajaran::where('id', $id)->with('guru')->first(), 200, 'success', 'Data Mata Pelajaran Success Updated');
    }

    public function delete($id)
    {
        // Validate Data
        $data = MataPelajaran::with('guru')
            ->where('id', $id);
        if (!$data->first()) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Data Mata Pelajaran Not Found'
            ], 404);
        }

        // Create Res Data
        $resData = $data->first();

        // Delete Data
        $data->delete();

        // Return Response With Json Resource
        return new MataPelajaranResource($resData, 200, 'success', 'Data Mata Pelajaran Success Deleted!');
    }
}
