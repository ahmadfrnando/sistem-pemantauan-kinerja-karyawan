<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KaryawanRequest;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ManajemenKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Karyawan::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" data-id="' . $row->id . '" id="edit" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form">Ubah</button>';
                    $btn .= '<button type="button" data-id="' . $row->id . '" id="delete" class="ms-2 btn btn-sm btn-danger">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.manajemen-karyawan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.manajemen-karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KaryawanRequest $request)
    {
        $validatedData = $request->validated();
        $id = $request->input('id');
        try {
            if ($id) {
                $karyawan = Karyawan::findOrFail($id);
                $karyawan->update($validatedData);
            } else {
                $karyawan = Karyawan::create($validatedData);
            }
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $karyawan
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
        $karyawan = Karyawan::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $karyawan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KaryawanRequest $request, string $id)
    {
        $validatedData = $request->validated();
        try {
            $karyawan = Karyawan::findOrFail($id);
            $karyawan->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan Update: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $karyawan = Karyawan::findOrFail($id);
            DB::beginTransaction();
            if ($karyawan->delete()) {
                if ($karyawan->karyawan) {
                    $karyawan->karyawan->update(['karyawan_id' => null]);
                }
                DB::commit();
                return response()->json(['success' => 'karyawan deleted successfully']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete karyawan: ' . $th->getMessage()], 500);
        }
    }
}
