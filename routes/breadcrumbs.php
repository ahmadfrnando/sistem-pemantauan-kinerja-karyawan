<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// admin
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Pages', route('admin.dashboard'));
});

// admin -> manajemen-pengguna
Breadcrumbs::for('admin.manajemen-pengguna.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manajemen Pengguna', route('admin.manajemen-pengguna.index'));
});

// admin -> manajemen-karyawan
Breadcrumbs::for('admin.manajemen-karyawan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manajemen Karyawan', route('admin.manajemen-karyawan.index'));
});

// admin -> manajemen-evaluasi-kinerja
Breadcrumbs::for('admin.manajemen-evaluasi-kinerja.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Evaluasi Kinerja', route('admin.manajemen-evaluasi-kinerja.index'));
});

// admin -> manajemen-evaluasi-kinerja -> show
Breadcrumbs::for('admin.manajemen-evaluasi-kinerja.show', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.manajemen-evaluasi-kinerja.index');
    $trail->push('Detail', route('admin.manajemen-evaluasi-kinerja.show', 'id'));
});

// admin -> manajemen-tugas
Breadcrumbs::for('admin.manajemen-tugas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manajemen Tugas', route('admin.manajemen-tugas.index'));
});

// admin -> manajemen-tugas -> add
Breadcrumbs::for('admin.manajemen-tugas.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.manajemen-tugas.index');
    $trail->push('Tambah Tugas', route('admin.manajemen-tugas.create'));
});

// admin -> manajemen-tugas -> edit
Breadcrumbs::for('admin.manajemen-tugas.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.manajemen-tugas.index');
    $trail->push('Ubah Tugas', route('admin.manajemen-tugas.edit', 'id'));
});

// karyawan
Breadcrumbs::for('karyawan.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Pages', route('karyawan.dashboard'));
});
// karyawan -> daftar tugas
Breadcrumbs::for('karyawan.daftar-tugas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan.dashboard');
    $trail->push('Tugas', route('karyawan.daftar-tugas.index'));
});

// karyawan -> riwayat tugas
Breadcrumbs::for('karyawan.riwayat-tugas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan.dashboard');
    $trail->push('Riwayat', route('karyawan.riwayat-tugas.index'));
});

// karyawan -> absensi harian
Breadcrumbs::for('karyawan.absensi-harian.index', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan.dashboard');
    $trail->push('Absensi Harian', route('karyawan.absensi-harian.index'));
});