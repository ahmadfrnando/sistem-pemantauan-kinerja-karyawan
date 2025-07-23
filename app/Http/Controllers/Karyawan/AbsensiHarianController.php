<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\DataKaryawanAbsen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $absen = DataKaryawanAbsen::where('karyawan_id', Karyawan::where('user_id', auth()->user()->id)->first()->id)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();
        return view('pages.karyawan.absensi-harian.index', compact('absen'));
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
        if ($request->ajax()) {
            try {
                $request->validate([
                    'bukti_absen' => 'required',
                ]);
                $absen = new DataKaryawanAbsen();
                $absen->jenis_absen = 'masuk';
                $absen->jam_absen = date('H:i:s');
                $absen->tanggal = date('Y-m-d');
                $absen->karyawan_id = Karyawan::where('user_id', auth()->user()->id)->first()->id;
                if ($request->bukti_absen) {
                    $folderPath = "public/absensi-harian/";
                    $image_parts = explode(";base64,", $request->bukti_absen);
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
                    $file = $folderPath . $fileName;
                    Storage::put($file, $image_base64);
                }
                $absen->bukti_absen = $fileName;
                $absen->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil disimpan!',
                    'data' => $absen
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
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
