<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rox()
    {
        return User::where('organisation_id', $this->id)->count();
    }
}
