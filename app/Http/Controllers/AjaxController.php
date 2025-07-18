<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getKaryawan(Request $request)
    {
        $searchTerm = $request->input('q');  // Ambil query parameter 'q'

        // Lakukan pencarian berdasarkan kode_pengangkutan yang cocok dengan query
        $karyawan = \App\Models\Karyawan::where('nama', 'LIKE', '%' . $searchTerm . '%')  // Filter berdasarkan kata kunci
            ->get(['id', 'nama'])  // Ambil hanya kolom id dan kode_pengangkutan
            ->toArray();

        // Format respons agar sesuai dengan struktur yang diinginkan oleh select2
        // $formattedData = array_map(function ($item) {
        //     return [
        //         'id' => $item['id'],
        //         'text' => $item['kode_pengangkutan']
        //     ];
        // }, $pengangkutan);

        return response()->json($karyawan);  // Kembalikan sebagai JSON
    }
}
