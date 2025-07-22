<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\ManajemenTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DaftarTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $karyawan;

    public function __construct()
    {
        $this->karyawan = Karyawan::where('user_id', Auth::id());
    }

    public function index()
    {
        $karyawan = $this->karyawan->first();
        $tugasBelum = ManajemenTugas::where(['karyawan_id' => 3])->where('status_tugas_id', 1)->orderBy('created_at', 'desc')->paginate(5);
        $tugasSudah = ManajemenTugas::where(['karyawan_id' => 3])->where('status_tugas_id', 2)->orderBy('created_at', 'desc')->paginate(5);

        $tugas = [
            'tugasBelum' => $tugasBelum,
            'tugasSudah' => $tugasSudah
        ];

        return view('pages.karyawan.daftar-tugas.index', compact('tugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:manajemen_tugas,id',
            'file' => 'required'
        ]);

        try {
            if ($request->ajax) {
                $tugas = ManajemenTugas::findOrFail($validatedData['id']);
                $file_name = time() . '.' . request()->file->getClientOriginalExtension();
                request()->file->move(storage_path('tugas'), $file_name);
                $tugas->file = $file_name;
                $tugas->status_tugas_id = 3;
                $tugas->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Tugas berhasil disimpan Yeay',
                    'data' => $tugas
                ], 200);
            }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jenis = $request->get('jenis');
        try {
            if ($request->ajax()) {
                $data = ManajemenTugas::find($id);
                if ($data) {
                    switch ($data->status_tugas_id) {
                        case 1:
                            $status = 2;
                            break;
                        case 2:
                            $status = 3;
                            break;
                    }
                    $data->status_tugas_id = $status;
                    if ($jenis === 'assigned') {
                        $data->tanggal_mulai = now()->toDateString();
                    } else {
                        $validated = $request->validate([
                            'capaian' => 'required|string',
                            'file' => 'required|mimes:jpg,jpeg,png'
                        ]);
                        if ($request->hasFile('file')) {
                            $file_name = time() . '.' . request()->file->getClientOriginalExtension();
                            request()->file->move(storage_path('tugas'), $file_name);
                            $data->file = $file_name;
                        }
                        $data->tanggal_selesai = now()->toDateString();
                        $data->capaian = $validated['capaian'];
                    }
                    $data->save();
                    return response()->json([
                        'success' => true,
                        'message' => $status == 2 ? 'Tugas berhasil diambil!' : 'Tugas berhasil diselesaikan!',
                        'data' => $data
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak ditemukan!'
                    ], 404);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateTugas(Request $request, $jenis, $id)
    {
        try {
            if ($request->ajax()) {
                $data = ManajemenTugas::find($id);
                if ($data) {
                    switch ($data->status_tugas_id) {
                        case 1:
                            $status = 2;
                            break;
                        case 2:
                            $status = 3;
                            break;
                    }
                    $data->status_tugas_id = $status;
                    if ($jenis === 'assigned') {
                        $data->tanggal_mulai = now()->toDateString();
                    } else {
                        $validated = $request->validate([
                            'capaian' => 'required|string',
                            'file' => 'required|mimes:jpg,jpeg,png'
                        ]);
                        if ($request->hasFile('file')) {
                            $file_name = time() . '.' . request()->file->getClientOriginalExtension();
                            request()->file->move(storage_path('app/public/tugas'), $file_name);
                            $data->file = $file_name;
                        }
                        $data->tanggal_selesai = now()->toDateString();
                        $data->capaian = $validated['capaian'];
                    }
                    $data->save();
                    return response()->json([
                        'success' => true,
                        'message' => $status == 2 ? 'Tugas berhasil diambil!' : 'Tugas berhasil diselesaikan!',
                        'data' => $data
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak ditemukan!'
                    ], 404);
                }
            }
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
    public function destroy(string $id)
    {
        //
    }
}
