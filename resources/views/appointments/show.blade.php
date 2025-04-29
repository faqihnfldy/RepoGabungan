@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Detail Janji Temu') }}</h5>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-sm">
                        {{ __('Kembali') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted">Status:</h6>
                                <span class="badge bg-{{ 
                                    $appointment->status === 'pending' ? 'warning' : 
                                    ($appointment->status === 'confirmed' ? 'success' : 
                                    ($appointment->status === 'completed' ? 'info' : 'secondary')) 
                                }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Informasi Pasien</h6>
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">{{ $appointment->patient->name }}</dd>
                                
                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $appointment->patient->email }}</dd>
                            </dl>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Informasi Dokter</h6>
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">{{ $appointment->doctor->name }}</dd>
                                
                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $appointment->doctor->email }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Detail Jadwal</h6>
                            <dl class="row">
                                <dt class="col-sm-3">Tanggal</dt>
                                <dd class="col-sm-9">{{ $appointment->appointment_date->format('d F Y') }}</dd>
                                
                                <dt class="col-sm-3">Waktu</dt>
                                <dd class="col-sm-9">{{ $appointment->appointment_date->format('H:i') }} WIB</dd>
                                
                                @if($appointment->notes)
                                    <dt class="col-sm-3">Catatan</dt>
                                    <dd class="col-sm-9">{{ $appointment->notes }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'admin' && $appointment->status === 'pending')
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <form action="{{ route('appointments.update-status', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="submit" name="status" value="confirmed" class="btn btn-success">
                                            {{ __('Konfirmasi Janji Temu') }}
                                        </button>
                                        <button type="submit" name="status" value="cancelled" class="btn btn-danger">
                                            {{ __('Batalkan Janji Temu') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection