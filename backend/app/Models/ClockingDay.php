<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClockingDay extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'clocking_days';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'notes',
        'coffee_break_in',
        'coffee_break_out',
        'lunch_break_in',
        'lunch_break_out',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i:s',
        'check_out' => 'datetime:H:i:s',
        'coffee_break_in' => 'datetime:H:i:s',
        'coffee_break_out' => 'datetime:H:i:s',
        'lunch_break_in' => 'datetime:H:i:s',
        'lunch_break_out' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the clocking day record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
