<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>PINJAMAN</h3>
                @php
                  $pinjam = 0;
                  $angsur = 0;
                  $lama = 0;
                  $denda = 0;
                  $status = '';
                  $deadline = '';
                  foreach($pinjaman as $p){
                    $pinjam = $p->jum_pinjaman;
                  }
                  foreach($angsuran as $a){
                    $angsur = $a->angsur->besar_angsuran;
                    $lama = $a->lama;
                    $denda = ($a->angsur->jum_pinjaman * (0.9/100/12));
                    $status = $a->status_angsur;
                    $deadline = $a->jatuh_tempo;
                  }
                @endphp
                @if($pinjam === null || $status == 'Lunas')
                  <p>
                    <?php 
                      echo "Rp. 0";
                    ?>
                  </p>
                  @else
                  <p>
                    <?php 
                      echo "Rp. " .number_format($pinjam, 0, '', '.');
                    ?>
                  </p>
                @endif
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>DENDA</h3>

                <p>
                  @if($angsur === null || date('Y-m-d') < $deadline)
                    <p>
                      <?php 
                        echo "Rp. 0";
                      ?>
                    </p>
                    @else
                    <p>
                      <?php 
                        echo "Rp. " .number_format($denda, 0, '', '.');
                      ?>
                    </p>
                  @endif
                </p>
              </div>
              <div class="icon">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>ANGSURAN</h3>
                @if($angsur === null || $status == 'Lunas')
                  <p>
                    <?php 
                      echo "Rp. 0";
                    ?>
                    <br> 0 dari 12 bulan
                  </p>
                  @else
                  <p>
                    <?php 
                      echo "Rp. " .number_format($angsur, 0, '', '.');
                    ?>
                    <br> {{ $lama }} dari 12 bulan
                  </p>
                @endif
              </div>
              <div class="icon">
                <i class="fas fa-copy"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</body>
</html>