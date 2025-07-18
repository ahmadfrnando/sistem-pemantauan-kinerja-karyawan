<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ManajemenPenggunaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')->where('role', '!=', 'admin');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" data-id="' . $row->id . '" id="edit" data-bs-toggle="modal" data-bs-target="#modal-form" class="btn btn-sm btn-primary">Ubah Password</button>';
                    $btn .= '<button type="button" data-id="' . $row->id . '" id="delete" class="ms-2 btn btn-sm btn-danger">Hapus</button>';
                    return $btn;
                })
                ->editColumn('is_online', function ($row) {
                    return $row->is_online ? '<span class="badge bg-success">Online</span>' : '<span class="badge bg-secondary">Offline</span>';
                })
                ->rawColumns(['action', 'is_online'])
                ->make(true);
        }
        return view('pages.admin.pengguna.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.pengguna.edit', compact('user'));
    }

    public function update(UserPasswordRequest $request, string $id)
    {
        $validatedData = $request->validated();
        try {
            $user = User::findOrFail($id);
            $user->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            DB::beginTransaction();
            if ($user->delete()) {
                if ($user->karyawan) {
                    $user->karyawan->update(['user_id' => null]);
                }
                DB::commit();
                return response()->json(['success' => 'User deleted successfully']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete user: ' . $th->getMessage()], 500);
        }
    }
}
