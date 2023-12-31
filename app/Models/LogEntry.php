<?php

namespace App\Models;

use App\Filters\LogEntryFilter;
use App\Models\Scopes\OrganisationLogEntryScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\LogEntryClassEnum;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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
        'acknowledged_at' => 'datetime',
        'class' => LogEntryClassEnum::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new OrganisationLogEntryScope);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function acknowledgedfrom()
    {
        return $this->belongsTo(User::class, 'acknowledged_from', 'id');
    }

    public function scopeFilter(Builder $query, array $filters = null)
    {
        if (isset($filters))
        {
            $logEntryFilter = new LogEntryFilter();

            foreach ($filters as $filter => $value) {
                if (method_exists($logEntryFilter, $filter)) {
                    $query = $logEntryFilter->$filter($query, $value);
                }
            }
            
        }
        
        return $query;
    }
}
