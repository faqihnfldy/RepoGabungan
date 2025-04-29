@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Dashboard Dokter</h5>
        </div>
        <div class="card-body">
            <h4>Selamat Datang, Dr. {{ Auth::user()->name }}!</h4>
            
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-calendar-alt text-primary"></i> Lihat Jadwal
                            </h5>
                            <p class="card-text">Lihat jadwal praktek Anda</p>
                            <a href="{{ route('doctor.schedule') }}" class="btn btn-primary">Lihat Jadwal</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-plus-circle text-success"></i> Tambah Jadwal
                            </h5>
                            <p class="card-text">Tambah jadwal praktek baru</p>
                            <a href="{{ route('doctor.schedule.create') }}" class="btn btn-success">Tambah Jadwal</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-history text-info"></i> Riwayat Janji Temu
                            </h5>
                            <p class="card-text">Lihat riwayat janji temu dengan pasien</p>
                            <a href="{{ route('doctor.appointments.history') }}" class="btn btn-info">Lihat Riwayat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-comments text-success"></i> Chat Pasien
                            </h5>
                            <p class="card-text">Konsultasi langsung dengan pasien melalui fitur chat</p>
                            <a href="{{ route('chat.index') }}" class="btn btn-success text-white">Mulai Chat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
