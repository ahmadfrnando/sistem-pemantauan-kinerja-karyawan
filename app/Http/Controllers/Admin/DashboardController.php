<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKaryawanAbsen;
use App\Models\Karyawan;
use App\Models\ManajemenTugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'ringkasanKehadiran' => $this->statsOverviewRingkasanKehadiran(),
            'tugasDiberikan' => $this->statsOverviewTugasDiberikan(),
            'tugasDikerjakan' => $this->statsOverviewTugasDikerjakan(),
            'tugasSelesai' => $this->statsOverviewTugasSelesai(),
        ];

        $charts = [
            'absenMingguan' => $this->chartAbsenMingguan(),
            'pemberianTugasMingguan' => $this->chartPemberianTugasMingguan(),
            'penyelesaianTugasMingguan' => $this->chartPenyelesaianTugasMingguan(),
        ];

        $tables = [
            'kinerjaKaryawan' => $this->tableKinerjaKaryawan(),
        ];

        $lists = [
            'karyawanTidakHadir' => $this->listKaryawanTidakHadir(),
        ];

        return view('pages.admin.dashboard', compact('stats', 'charts', 'tables', 'lists'));
    }

    private function statsOverviewRingkasanKehadiran()
    {
        $absensi = DataKaryawanAbsen::all();
        $karyawan = Karyawan::all();
        $persentase = 0;
        $hasilPersentase = '';
        $waktu = [
            'hariIni' => date('Y-m-d'),
            'kemarin' => date('Y-m-d', strtotime('-1 day')),
        ];

        $ringkasanKehadiranHariIni = $absensi->where('status', 'hadir')->where('jenis_absen', 'masuk')->where('tanggal', $waktu['hariIni'])->count();
        $ringkasanKehadiranKemarin = $absensi->where('status', 'hadir')->where('jenis_absen', 'masuk')->where('tanggal', $waktu['kemarin'])->count();
        $totalKaryawan = $karyawan->count();
        $persentaseHariIni = intval(($ringkasanKehadiranHariIni / $totalKaryawan) * 100);
        $persentaseKemarin = intval(($ringkasanKehadiranKemarin / $totalKaryawan) * 100);

        if ($persentaseHariIni > $persentaseKemarin) {
            $persentase = $persentaseHariIni - $persentaseKemarin;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+' . $persentase . '% </span>dibandingkan kemarin</p>';
        } else {
            $persentase = $persentaseKemarin - $persentaseHariIni;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-' . $persentase . '% </span>dibandingkan kemarin</p>';
        }

        return [
            'ringkasanKehadiranHariIni' => $ringkasanKehadiranHariIni,
            'hasilPersentase' => $hasilPersentase
        ];
    }

    private function statsOverviewTugasDiberikan()
    {
        $tugas = ManajemenTugas::all();
        $karyawan = Karyawan::all();
        $waktu = [
            'hariIni' => date('Y-m-d'),
            'kemarin' => date('Y-m-d', strtotime('-1 day')),
        ];

        $tugasDiberikanHariIni = $tugas->where('created_at', $waktu['hariIni'])->count();
        $tugasDiberikanKemarin = $tugas->where('created_at', $waktu['kemarin'])->count();
        $totalKaryawan = $karyawan->count();
        $persentaseHariIni = intval(($tugasDiberikanHariIni / $totalKaryawan) * 100);
        $persentaseKemarin = intval(($tugasDiberikanKemarin / $totalKaryawan) * 100);

        if ($persentaseHariIni > $persentaseKemarin) {
            $persentase = $persentaseHariIni - $persentaseKemarin;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+' . $persentase . '% </span>dibandingkan kemarin</p>';
        } else {
            $persentase = $persentaseKemarin - $persentaseHariIni;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-' . $persentase . '% </span>dibandingkan kemarin</p>';
        }

        return [
            'tugasDiberikanHariIni' => $tugasDiberikanHariIni,
            'hasilPersentase' => $hasilPersentase
        ];
    }

    private function statsOverviewTugasDikerjakan()
    {
        $tugas = ManajemenTugas::all();
        $karyawan = Karyawan::all();
        $waktu = [
            'hariIni' => date('Y-m-d'),
            'kemarin' => date('Y-m-d', strtotime('-1 day')),
        ];

        $tugasDikerjakanHariIni = $tugas->where('tanggal_mulai', $waktu['hariIni'])->where('status_tugas_id', 2)->count();
        $tugasDikerjakanKemarin = $tugas->where('tanggal_mulai', $waktu['kemarin'])->where('status_tugas_id', 2)->count();
        $totalKaryawan = $karyawan->count();
        $persentaseHariIni = intval(($tugasDikerjakanHariIni / $totalKaryawan) * 100);
        $persentaseKemarin = intval(($tugasDikerjakanKemarin / $totalKaryawan) * 100);

        if ($persentaseHariIni > $persentaseKemarin) {
            $persentase = $persentaseHariIni - $persentaseKemarin;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+' . $persentase . '% </span>dibandingkan kemarin</p>';
        } else {
            $persentase = $persentaseKemarin - $persentaseHariIni;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-' . $persentase . '% </span>dibandingkan kemarin</p>';
        }

        return [
            'tugasDikerjakanHariIni' => $tugasDikerjakanHariIni,
            'hasilPersentase' => $hasilPersentase
        ];
    }

    private function statsOverviewTugasSelesai()
    {
        $tugas = ManajemenTugas::all();
        $karyawan = Karyawan::all();
        $waktu = [
            'hariIni' => date('Y-m-d'),
            'kemarin' => date('Y-m-d', strtotime('-1 day')),
        ];

        $tugasSelesaiHariIni = $tugas->where('tanggal_selesai', $waktu['hariIni'])->where('status_tugas_id', 3)->count();
        $tugasSelesaiKemarin = $tugas->where('tanggal_selesai', $waktu['kemarin'])->where('status_tugas_id', 3)->count();
        $totalKaryawan = $karyawan->count();
        $persentaseHariIni = intval(($tugasSelesaiHariIni / $totalKaryawan) * 100);
        $persentaseKemarin = intval(($tugasSelesaiKemarin / $totalKaryawan) * 100);

        if ($persentaseHariIni > $persentaseKemarin) {
            $persentase = $persentaseHariIni - $persentaseKemarin;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+' . $persentase . '% </span>dibandingkan kemarin</p>';
        } else {
            $persentase = $persentaseKemarin - $persentaseHariIni;
            $hasilPersentase = '<p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-' . $persentase . '% </span>dibandingkan kemarin</p>';
        }

        return [
            'tugasSelesaiHariIni' => $tugasSelesaiHariIni,
            'hasilPersentase' => $hasilPersentase
        ];
    }

    private function chartAbsenMingguan()
    {
        $hariIni = Carbon::today();

        $dataAbsensi = DataKaryawanAbsen::whereBetween('tanggal', [$hariIni->copy()->subDays(6)->format('Y-m-d'), $hariIni->copy()->format('Y-m-d')])
            ->where('jenis_absen', 'masuk')
            ->select(DB::raw('DAYOFWEEK(tanggal) as day, COUNT(*) as total_data'))
            ->groupBy(DB::raw('DAYOFWEEK(tanggal)'))
            ->get();

        $today = Carbon::today();
        $startDate = $today->subDays(6);
        $endDate = $today;

        $weekDays = ['M', 'S', 'S', 'R', 'K', 'J', 'S']; // Senin - Minggu
        $weekDaysNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; // Senin - Minggu

        $labels = [];
        $data = [0, 0, 0, 0, 0, 0, 0];

        for ($i = 0; $i < 7; $i++) {
            $currentDay = $startDate->copy()->addDays($i)->format('l');

            $dayIndex = $this->getDayIndex($currentDay);
            $labels[] = $weekDays[$dayIndex];
            $labelsNama[] = $weekDaysNama[$dayIndex];
        }

        foreach ($dataAbsensi as $view) {
            $data[$view->day - 1] = $view->total_data;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'labelsNama' => $labelsNama,
            'tglMulai' => $startDate->format('d M'),
            'tglSelesai' => $startDate->addDays(6)->format('d M')
        ];
    }

    private function chartPemberianTugasMingguan()
    {
        $hariIni = Carbon::today();

        $dataAbsensi = ManajemenTugas::whereBetween('created_at', [$hariIni->copy()->subDays(6)->format('Y-m-d'), $hariIni->copy()->format('Y-m-d')])
            ->select(DB::raw('DAYOFWEEK(created_at) as day, COUNT(*) as total_data'))
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

        $today = Carbon::today();
        $startDate = $today->subDays(6);
        $endDate = $today;

        $weekDays = ['M', 'S', 'S', 'R', 'K', 'J', 'S']; // Senin - Minggu
        $weekDaysNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; // Senin - Minggu

        $labels = [];
        $data = [0, 0, 0, 0, 0, 0, 0];

        for ($i = 0; $i < 7; $i++) {
            $currentDay = $startDate->copy()->addDays($i)->format('l');

            $dayIndex = $this->getDayIndex($currentDay);
            $labels[] = $weekDays[$dayIndex];
            $labelsNama[] = $weekDaysNama[$dayIndex];
        }

        foreach ($dataAbsensi as $view) {
            $data[$view->day - 1] = $view->total_data;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'labelsNama' => $labelsNama,
            'tglMulai' => $startDate->format('d M'),
            'tglSelesai' => $startDate->addDays(6)->format('d M')
        ];
    }

    private function chartPenyelesaianTugasMingguan()
    {
        $hariIni = Carbon::today();

        $dataAbsensi = ManajemenTugas::whereBetween('tanggal_selesai', [$hariIni->copy()->subDays(6)->format('Y-m-d'), $hariIni->copy()->format('Y-m-d')])
            ->select(DB::raw('DAYOFWEEK(tanggal_selesai) as day, COUNT(*) as total_data'))
            ->groupBy(DB::raw('DAYOFWEEK(tanggal_selesai)'))
            ->get();

        $today = Carbon::today();
        $startDate = $today->subDays(6);
        $endDate = $today;

        $weekDays = ['M', 'S', 'S', 'R', 'K', 'J', 'S']; // Senin - Minggu
        $weekDaysNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; // Senin - Minggu
        $labels = [];
        $data = [0, 0, 0, 0, 0, 0, 0];

        for ($i = 0; $i < 7; $i++) {
            $currentDay = $startDate->copy()->addDays($i)->format('l');

            $dayIndex = $this->getDayIndex($currentDay);
            $labels[] = $weekDays[$dayIndex];
            $labelsNama[] = $weekDaysNama[$dayIndex];
        }

        foreach ($dataAbsensi as $view) {
            $data[$view->day - 1] = $view->total_data;
        }

        return [
            'labels' => $labels,
            'labelsNama' => $labelsNama,
            'data' => $data,
            'tglMulai' => $startDate->format('d M'),
            'tglSelesai' => $startDate->addDays(6)->format('d M')
        ];
    }

    private function getDayIndex($dayName)
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return array_search($dayName, $days);
    }

    private function tableKinerjaKaryawan()
    {
        $karyawanTugas = Karyawan::select('karyawan.id', 'karyawan.nama')
            ->leftJoin('manajemen_tugas', 'karyawan.id', '=', 'manajemen_tugas.karyawan_id')
            ->where('manajemen_tugas.created_at', '>=', Carbon::now()->subMonth())
            ->selectRaw('
                COUNT(manajemen_tugas.id) as total_tugas,
                SUM(CASE WHEN manajemen_tugas.status_tugas_id = 3 AND manajemen_tugas.tanggal_selesai IS NOT NULL THEN 1 ELSE 0 END) as tugas_selesai
            ')
            ->groupBy('karyawan.id', 'karyawan.nama')
            ->get();

        foreach ($karyawanTugas as $karyawan) {
            $karyawan->persentase_kesiapan = 0;
            if ($karyawan->total_tugas > 0) {
                $karyawan->persentase_kesiapan = ($karyawan->tugas_selesai / $karyawan->total_tugas) * 100;
            }
        }

        return [
            'karyawanTugas' => $karyawanTugas,
            'totalSemuaTugas' => ManajemenTugas::where('status_tugas_id', 3)
                ->where('tanggal_selesai', '>=', Carbon::now()->subMonth()->format('Y-m-d'))
                ->count(),
        ];
    }

    private function listKaryawanTidakHadir()
    {
        $today = Carbon::now()->format('Y-m-d');

        $listKaryawanTidakHadir = Karyawan::whereNotIn('id', function ($query) use ($today) {
            $query->select('karyawan_id')
                ->from('data_karyawan_absen')
                ->where('tanggal', $today)
                ->whereNotNull('jenis_absen');
        })->get();

        return [
            'totalTidakHadir' => $listKaryawanTidakHadir->count(),
            'listKaryawanTidakHadir' => $listKaryawanTidakHadir
        ];
    }
}
