@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Janji Temu</h4>
                </div>
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Dokter</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->appointment_date->format('d M Y H:i') }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td>
                                                @if($appointment->status === 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($appointment->status === 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($appointment->status === 'completed')
                                                    <span class="badge bg-info">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @endif
                                            </td>
                                            <td>{{ $appointment->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $appointments->links() }}
                        </div>
                    @else
                        <p class="text-center">Belum ada riwayat janji temu.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection