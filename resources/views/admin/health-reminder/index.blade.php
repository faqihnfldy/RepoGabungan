@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Health Reminder</h5>
            <a href="{{ route('admin.health-reminder.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Reminder
            </a>
        </div>
        <div class="card-body">
            @if($reminders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pasien</th>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Waktu</th>
                                <th>Frekuensi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reminders as $reminder)
                                <tr>
                                    <td>{{ $reminder->patient->name }}</td>
                                    <td>{{ $reminder->title }}</td>
                                    <td>{{ ucfirst($reminder->reminder_type) }}</td>
                                    <td>{{ $reminder->reminder_time }}</td>
                                    <td>{{ ucfirst($reminder->frequency) }}</td>
                                    <td>
                                        @if($reminder->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.health-reminder.edit', $reminder->id) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.health-reminder.destroy', $reminder->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus reminder ini?')" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">Belum ada health reminder yang dibuat.</p>
            @endif
        </div>
    </div>
</div>
@endsection