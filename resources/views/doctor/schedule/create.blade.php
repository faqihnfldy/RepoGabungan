@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Jadwal Praktik</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('doctor.schedule.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="day" class="form-label">Hari</label>
                    <select name="day" id="day" class="form-select" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                </div>

                <div class="mb-3">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                </div>

                <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
            </form>
        </div>
    </div>
</div>
@endsection