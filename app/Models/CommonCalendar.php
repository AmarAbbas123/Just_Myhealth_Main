<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CommonCalendar extends Model
{
    protected $table = 'sys_user_type_30_common_calendar';
    protected $guarded = ['ID'];
    protected $primaryKey = 'ID';
    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Casts (helpful)
    protected $casts = [
        'DateFrom' => 'date',
        'DateTo' => 'date',
        'TimeFrom' => 'string',
        'TimeTo' => 'string',
        'SessionDateTimeFrom' => 'datetime',
        'SessionDateTimeTo' => 'datetime',
    ];

    // Relationship helpers
    public function therapist()
    {
        return $this->belongsTo(User::class, 'TherapistUserID', 'ID');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'PatientUserID', 'ID');
    }

    /**
     * Return a Carbon instance for DateFrom+TimeFrom in therapist timezone (or UTC fallback)
     */
    public function startCarbon()
    {
        $tz = $this->TherapistTimeZone ?: '+00:00';
        return Carbon::parse($this->DateFrom->format('Y-m-d') . ' ' . $this->TimeFrom, $tz);
    }

    public function endCarbon()
    {
        $tz = $this->TherapistTimeZone ?: '+00:00';
        return Carbon::parse($this->DateTo->format('Y-m-d') . ' ' . $this->TimeTo, $tz);
    }
}
    