@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Health Reminder</h5>
            <a href="{{ route('admin.health-reminder.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.health-reminder.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Pasien</label>
                    <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Reminder</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="reminder_type" class="form-label">Tipe Reminder</label>
                    <select name="reminder_type" id="reminder_type" class="form-select @error('reminder_type') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="medication" {{ old('reminder_type') == 'medication' ? 'selected' : '' }}>Pengobatan</option>
                        <option value="checkup" {{ old('reminder_type') == 'checkup' ? 'selected' : '' }}>Pemeriksaan</option>
                        <option value="exercise" {{ old('reminder_type') == 'exercise' ? 'selected' : '' }}>Olahraga</option>
                    </select>
                    @error('reminder_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="reminder_time" class="form-label">Waktu Reminder</label>
                    <input type="time" class="form-control @error('reminder_time') is-invalid @enderror" 
                           id="reminder_time" name="reminder_time" value="{{ old('reminder_time') }}" required>
                    @error('reminder_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="frequency" class="form-label">Frekuensi</label>
                    <select name="frequency" id="frequency" class="form-select @error('frequency') is-invalid @enderror" required>
                        <option value="">-- Pilih Frekuensi --</option>
                        <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                    @error('frequency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               value="1" {{ old('is_active') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktifkan Reminder
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection