<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManajemenTugasRequest;
use App\Models\Karyawan;
use App\Models\ManajemenTugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ManajemenTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ManajemenTugas::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.manajemen-tugas.edit', $row->id) . '" class="btn btn-sm btn-primary">Ubah</a>';
                    $btn .= '<button type="button" data-id="' . $row->id . '" id="delete" class="ms-2 btn btn-sm btn-danger">Hapus</button>';
                    return $btn;
                })
                ->addColumn('karyawan', function ($row) {
                    return $row->karyawan->nama ?? '-';
                })
                ->addColumn('status', function ($row) {
                    switch ($row->status_tugas_id) {
                        case 1:
                            return '<span class="badge bg-danger">' . $row->status->status . '</span>';
                            break;
                        case 2:
                            return '<span class="badge bg-warning">' . $row->status->status . '</span>';
                            break;
                        case 3:
                            return '<span class="badge bg-success">' . $row->status->status . '</span>';
                            break;
                    }
                })
                ->rawColumns(['action', 'status', 'karyawan'])
                ->filterColumn('karyawan', function ($query, $value) {
                    $query->whereHas('karyawan', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.admin.manajemen-tugas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.manajemen-tugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManajemenTugasRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData = array_merge($validatedData, ['status_tugas_id' => 1]);
        try {
            $tugas = ManajemenTugas::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $tugas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tugas = ManajemenTugas::findOrFail($id);
        return view('pages.admin.manajemen-tugas.edit', compact('tugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManajemenTugasRequest $request, string $id)
    {
        $validatedData = $request->validated();
        try {
            $tugas = ManajemenTugas::findOrFail($id);
            $tugas->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $tugas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tugas = ManajemenTugas::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'data' => $tugas,
                'message' => 'Data berhasil dihapus!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ], 500);
        }
    }
}
