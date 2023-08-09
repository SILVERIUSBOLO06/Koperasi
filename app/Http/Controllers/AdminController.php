<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\User;
use App\Models\Angsuran;
use App\Models\JenisPinjaman;
use Hash;

class AdminController extends Controller
{
    public function index(){
        $pinjaman = Pinjaman::where('status','Diterima')->sum('jum_pinjaman');
        $angsuran = Pinjaman::sum('besar_angsuran');
        $anggota = User::where('role','anggota')->count();
        $denda = Angsuran::join('pinjaman','id_pinjaman','=','pinjaman.id')->where('angsuran.jatuh_tempo','<',date('Y-m-d'))->sum('jum_pinjaman') * (0.9/100/12);
        return view('admin.home', compact('pinjaman','angsuran','anggota','denda'));
    }

    public function anggota(){
        $anggota = User::where('role','anggota')->get();
        return view('admin.anggota', compact('anggota'));
    }

    public function pengajuan(){
        $pengajuan = Pinjaman::all()->sortDesc();
        return view('admin.pengajuan', compact('pengajuan'));
    }

    public function setuju($id){
        $p = Pinjaman::find($id);
        $p->status = 'Diterima';
        $p->tgl_terima = date('Y-m-d');
        $p->save();
        Angsuran::create([
            'lama' => '0',
            'status_angsur' => 'Belum Lunas',
            'jatuh_tempo' => '2023-'.date('m', strtotime('+1 month')).'-05',
            'id_pinjaman' => $p->id
        ]);
        return redirect()->back();
    }

    public function tolak($id){
        $p = Pinjaman::find($id);
        $p->status = 'Ditolak';
        $p->save();
        return redirect()->back();
    }

    public function transaksi(){
        $anggota = Angsuran::join('pinjaman','id_pinjaman','=','pinjaman.id')->join('users','id_anggota','=','users.id')->where('users.role','anggota')->where('pinjaman.id','<>',null)->where('pinjaman.status','Diterima')->where('angsuran.status_angsur','Belum Lunas')->get()->sortDesc();
        return view('admin.transaksi', compact('anggota'));
    }

    public function angsuran($id){
        $angsur = Angsuran::join('pinjaman','id_pinjaman','=','pinjaman.id')->where('id_anggota',$id)->get()->sortDesc();
        return view('admin.angsuran', compact('angsur'));
    }

    public function angsur($id){
        $variable = Angsuran::where('id_pinjaman',$id)->get();
        foreach ($variable as $key => $a) {
            $a->lama = ($a->lama+1);
            $a->jatuh_tempo = date('Y-m-d', strtotime('+1 month', strtotime($a->jatuh_tempo)));
            if ($a->lama == 12) {
                $a->status_angsur = 'Lunas';
            }
            $a->save();
        }
        return redirect()->back();
    }

    public function laporan_anggota(){
        $anggota = User::where('role','anggota')->get();
        return view('admin.laporan_anggota', compact('anggota'));
    }

    public function laporan_peminjaman(){
        $angsur = Angsuran::all()->sortDesc();
        return view('admin.laporan_pinjaman', compact('angsur'));
    }

    public function jenis_pinjaman(){
        $jenis = JenisPinjaman::all();
        return view('admin.jenis_pinjaman', compact('jenis'));
    }

    public function riwayat(){
        $angsur = Angsuran::all()->sortDesc();
        return view('admin.riwayat', compact('angsur'));
    }

    public function tambah_anggota(){
        return view('admin.tambah_anggota');
    }

    public function simpan_anggota(Request $request){
        $count = User::where('role','anggota')->count();
        User::create([
            'no_anggota' => '00'.($count+1),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ktp' => $request->ktp,
            'name' => $request->nama,
            'jekel' => $request->jekel,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'tgl_masuk' => date('Y-m-d'),
            'role' => 'anggota'
        ]);
        return redirect('data_anggota');
    }

    public function hapus_anggota($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
    }

    public function edit_anggota($id){
        $data = User::find($id);
        return view('admin.edit_anggota', compact('data'));
    }

    public function update_anggota($id, Request $request){
        $data = User::find($id);
        $data->email = $request->email;
        if ($request->password <> '') {
            $data->password = $request->password;
        }
        $data->ktp = $request->ktp;
        $data->name = $request->nama;
        $data->jekel = $request->jekel;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->pekerjaan = $request->pekerjaan;
        $data->alamat = $request->alamat;
        $data->save();
        return redirect('data_anggota');
    }

    public function tambah_pinjaman(){
        return view('admin.tambah_pinjaman');
    }

    public function simpan_pinjaman(Request $request){
        JenisPinjaman::create([
            'jenis_pinjaman' => $request->jenis,
            'max' => $request->max,
            'lama' => $request->lama,
            'bunga' => $request->bunga
        ]);
        return redirect('jenis_pinjaman');
    }

    public function hapus_pinjaman($id){
        $jenis = JenisPinjaman::find($id);
        $jenis->delete();
        return redirect()->back();
    }

    public function edit_pinjaman($id){
        $data = JenisPinjaman::find($id);
        return view('admin.edit_pinjaman', compact('data'));
    }

    public function update_pinjaman($id, Request $request){
        $data = JenisPinjaman::find($id);
        $data->jenis_pinjaman = $request->jenis;
        $data->bunga = $request->bunga;
        $data->max = $request->max;
        $data->lama = $request->lama;
        $data->save();
        return redirect('jenis_pinjaman');
    }
}