<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\JenisPinjaman;
use App\Models\Angsuran;
use Auth;

class AnggotaController extends Controller
{
    public function index(){
        $pinjaman = Pinjaman::select('jum_pinjaman')->where('id_anggota',Auth::id())->limit(1)->get(); 
        $angsuran = Angsuran::join('pinjaman','id_pinjaman','=','pinjaman.id')->where('pinjaman.id_anggota',Auth::id())->get();
        return view('anggota.home', compact('pinjaman','angsuran'));
    }

    public function pengajuan(){
        $pengajuan = Pinjaman::where('id_anggota',Auth::id())->get()->sortDesc();
        $jenis = JenisPinjaman::all();
        return view('anggota.pengajuan', compact('pengajuan','jenis'));
    }

    public function transaksi(){
        $angsuran = Angsuran::join('pinjaman','id_pinjaman','=','pinjaman.id')->where('pinjaman.id_anggota',Auth::id())->where('angsuran.status_angsur','Belum Lunas')->limit(1)->get()->sortDesc();
        return view('anggota.transaksi', compact('angsuran'));
    }

    public function riwayat(){
        $angsuran = Angsuran::join('pinjaman','id_pinjaman','=','pinjaman.id')->where('pinjaman.id_anggota',Auth::id())->where('angsuran.status_angsur','Lunas')->get()->sortDesc();
        return view('anggota.riwayat', compact('angsuran'));
    }

    public function simpan(Request $request){
        $count = Pinjaman::count();
        Pinjaman::create([
            'no_pinjam' => '00'.($count+1),
            'tgl_pengajuan' => date('Y-m-d'),
            'jum_pinjaman' => $request->pinjaman,
            'status' => 'Menunggu',
            'besar_angsuran' => (($request->pinjaman/12) + ($request->pinjaman*(0.75/100))),
            'id_anggota' => Auth::id(),
            'id_jenis' => $request->jenis
        ]);
        return redirect()->back();
    }
}
