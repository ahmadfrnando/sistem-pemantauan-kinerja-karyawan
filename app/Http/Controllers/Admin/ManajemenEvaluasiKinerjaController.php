<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvaluasiKinerjaRequest;
use App\Models\DataKaryawanAbsen;
use App\Models\EvaluasiKinerja;
use App\Models\EvaluasiKinerjaKaryawan;
use App\Models\Karyawan;
use App\Models\ManajemenTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ManajemenEvaluasiKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EvaluasiKinerja::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.manajemen-evaluasi-kinerja.show', $row->id) . '" class="btn btn-sm btn-outline-primary">Detail</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.manajemen-evaluasi-kinerja.index');
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
    public function store(EvaluasiKinerjaRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $data = EvaluasiKinerja::create($validatedData);

            if ($this->generateEvaluasi($data->id)) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil disimpan!',
                    'data' => $data
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal disimpan!'
                ], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateEvaluasi($idEvaluasi)
    {
        try {
            $data = EvaluasiKinerja::find($idEvaluasi);
            $karyawan = Karyawan::all();
            EvaluasiKinerjaKaryawan::where('evaluasi_kinerja_id', $idEvaluasi)->delete();
            foreach ($karyawan as $item) {
                $skorAbsensi = 0;
                $skorTugas = 0;
                $total = 0;

                $getAbsensi = DataKaryawanAbsen::where('karyawan_id', $item->id)
                    ->whereMonth('tanggal', $data->bulan)
                    ->whereYear('tanggal', $data->tahun)
                    ->where('status', 'hadir')
                    ->get();

                if ($getAbsensi->count() > 0) {
                    $skorAbsensi = intval(($getAbsensi->count() / 22) * 100);
                }

                $getTugas = ManajemenTugas::where('karyawan_id', $item->id)
                    ->whereMonth('created_at', $data->bulan)
                    ->whereYear('created_at', $data->tahun)
                    ->get();

                if ($getTugas->count() > 0) {
                    $skorTugas = intval(($getTugas->where('status_tugas_id', 3)->count() / $getTugas->count() * 100));
                }

                $total = ($skorAbsensi + $skorTugas) / 2;
                if ($total <= 50) {
                    $status = 'kurang';
                } elseif ($total > 50 && $total <= 75) {
                    $status = 'cukup';
                } elseif ($total > 75 && $total <= 90) {
                    $status = 'baik';
                } elseif ($total > 90) {
                    $status = 'sangat baik';
                }

                EvaluasiKinerjaKaryawan::create([
                    'evaluasi_kinerja_id' => $data->id,
                    'karyawan_id' => $item->id,
                    'bulan' => $data->bulan,
                    'tahun' => $data->tahun,
                    'skor_kehadiran' => $skorAbsensi,
                    'skor_tugas' => $skorTugas,
                    'total_skor' => $total,
                    'status_hasil' => $status
                ]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $evaluasi = EvaluasiKinerja::find($id);
        $data = EvaluasiKinerjaKaryawan::where('evaluasi_kinerja_id', $evaluasi->id)->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('karyawan', function ($row) {
                    return $row->karyawan->nama ?? '-';
                })
                ->addColumn('status_hasil', function ($row) {
                    switch ($row->status_hasil) {
                        case 'kurang':
                            return '<span class="badge bg-danger">' . $row->status_hasil . '</span>';
                            break;
                        case 'cukup':
                            return '<span class="badge bg-warning">' . $row->status_hasil . '</span>';
                            break;
                        case 'baik':
                            return '<span class="badge bg-primary">' . $row->status_hasil . '</span>';
                            break;
                        case 'sangat baik':
                            return '<span class="badge bg-success">' . $row->status_hasil . '</span>';
                            break;
                    }
                })
                ->rawColumns(['karyawan', 'status_hasil'])
                ->make(true);
        }

        return view('pages.admin.manajemen-evaluasi-kinerja.show', compact('evaluasi'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
