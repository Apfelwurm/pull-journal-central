<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\LogEntryClassEnum;

class LogEntry extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source',
        'class',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'aknowledged_at' => 'datetime',
        'class' => LogEntryClassEnum::class,
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function aknowledgedfrom()
    {
        return $this->belongsTo(User::class, 'aknowledged_from', 'id');
    }
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
