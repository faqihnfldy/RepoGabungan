<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reminder MedFast</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f8f8; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px;">
        <h2 style="color: #2d3748;">⏰ Pengingat Kesehatan dari MedFast</h2>

        <p>Halo,</p>

        <p>Berikut adalah pengingat dari dokter Anda melalui MedFast:</p>

        <hr>

        <h3 style="margin-top: 20px;">{{ $reminder->title }}</h3>

        @if ($reminder->description)
            <p>{{ $reminder->description }}</p>
        @endif

        <p><strong>Waktu Reminder:</strong> {{ \Carbon\Carbon::parse($reminder->reminder_time)->format('d M Y H:i') }}</p>

        <p><strong>Pasien:</strong> {{ $patient_name }}</p>
        <p><strong>Admin yang mengirimkan:</strong> {{ $doctor_name }}</p>

        <hr>

        <p>Semoga sehat selalu,</p>
        <p><strong>Tim MedFast</strong></p>
    </div>
</body>
</html>