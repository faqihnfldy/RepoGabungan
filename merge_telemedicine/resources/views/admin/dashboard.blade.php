@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Dashboard Admin</h2>

            <!-- Statistik -->
            <div class="row mb-4">
                <!-- Card Total Pasien -->
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Pasien</h6>
                                    <h2 class="mb-0">{{ \App\Models\User::where('role', 'user')->count() }}</h2>
                                </div>
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Dokter -->
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Dokter</h6>
                                    <h2 class="mb-0">{{ \App\Models\User::where('role', 'doctor')->count() }}</h2>
                                </div>
                                <i class="fas fa-user-md fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Janji Temu -->
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Janji Temu</h6>
                                    <h2 class="mb-0">{{ \App\Models\Appointment::count() }}</h2>
                                </div>
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Health Reminder -->
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Health Reminder</h6>
                                    <a href="{{ route('admin.health-reminder.index') }}" class="btn btn-light btn-sm mt-2">
                                        <i class="fas fa-bell"></i> Kelola Reminder
                                    </a>
                                </div>
                                <i class="fas fa-bell fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Janji Temu -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Janji Temu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Appointment::with(['patient', 'doctor'])->latest()->get() as $appointment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->appointment_date->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $appointment->status === 'pending' ? 'warning' : 
                                            ($appointment->status === 'confirmed' ? 'success' : 
                                            ($appointment->status === 'completed' ? 'info' : 'danger')) 
                                        }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm d-inline" style="width: auto" onchange="this.form.submit()">
                                                <option value="">Pilih Status</option>
                                                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection