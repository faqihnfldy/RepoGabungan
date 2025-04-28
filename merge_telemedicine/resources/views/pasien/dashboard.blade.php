@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dashboard Pasien</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
                    
                    <div class="mt-4">
                        <h5>Menu Cepat</h5>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-calendar-plus text-primary"></i> Buat Janji Temu
                                        </h5>
                                        <p class="card-text">Buat janji temu dengan dokter pilihan Anda</p>
                                        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                                            Buat Janji
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-history text-info"></i> Riwayat Janji Temu
                                        </h5>
                                        <p class="card-text">Lihat riwayat janji temu Anda</p>
                                        <a href="{{ route('appointments.history') }}" class="btn btn-info text-white">
                                            Lihat Riwayat
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-comments text-success"></i> Chat Dokter
                                        </h5>
                                        <p class="card-text">Konsultasi langsung dengan dokter melalui fitur chat</p>
                                        <a href="{{ route('chat.index') }}" class="btn btn-success text-white">
                                            Mulai Chat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection