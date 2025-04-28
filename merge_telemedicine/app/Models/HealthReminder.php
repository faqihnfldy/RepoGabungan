<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthReminder extends Model
{
    protected $fillable = [
        'patient_id',
        'title',
        'description',
        'reminder_type',
        'reminder_time',
        'frequency',
        'is_active'
    ];

    protected $casts = [
        'reminder_time' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}