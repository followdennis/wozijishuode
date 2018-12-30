<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'plan';
    protected $guarded = [];
    protected $except = ['name'];
}
