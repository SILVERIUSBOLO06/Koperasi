<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Pinjaman</title>
    <link rel="icon" href="logo_koperasi.png" type="image/png" />
</head>
<body>
@extends('layouts.dash')
@section('content')
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i> {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-power mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Pengajuan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Pengajuan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header" style="text-align: right;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> Tambah Pengajuan
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Pinjam</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Besar Pinjam</th>
                    <th>Lama Angsuran</th>
                    <th>Jenis Pinjam</th>
                    <th>Besar Angsuran</th>
                    <th>Status</th>
                    <th>Tanggal Terima</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php
                    $no = 1;
                  @endphp
                  @foreach($pengajuan as $p)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $p->no_pinjam }}</td>
                      <td>{{ $p->tgl_pengajuan }}</td>
                      <td>
                        <?php 
                          echo "Rp. " .number_format($p->jum_pinjaman, 0, '', '.');
                        ?>
                      </td>
                      <td>{{ $p->jenis->lama }} Bulan</td>
                      <td>{{ $p->jenis->jenis_pinjaman }}</td>
                      <td>
                        <?php 
                          echo "Rp. " .number_format($p->besar_angsuran, 0, '', '.');
                        ?>
                      </td>
                      <td>
                        @if($p->status == 'Menunggu')
                        <span class="badge bg-warning">Menunggu</span>
                        @elseif($p->status == 'Diterima')
                        <span class="badge bg-success">Diterima</span>
                        @else
                        <span class="badge bg-danger">Ditolak</span>
                        @endif
                      </td>
                      <td>{{ $p->tgl_terima }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pengajuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="tambahpengajuan" method="post">
                @csrf
                  <div class="form-group">
                    <label>Jenis Pinjaman</label>
                    <select class="form-control" name="jenis">
                      @foreach($jenis as $j)
                      <option value="{{ $j->id }}">{{ $j->jenis_pinjaman }}/Max <?php echo "Rp. " .number_format($j->max, 0, '', '.'); ?>/Bunga : {{ $j->bunga }}%/Lama : {{ $j->lama }} Bulan</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Besar Pinjaman</label>
                    <input type="number" class="form-control" placeholder="Input Besar Pinjaman" name="pinjaman">
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-primary">Ajukan</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</body>
</html>