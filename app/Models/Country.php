<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Country extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];
}
