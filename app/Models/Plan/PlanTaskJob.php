<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTaskJob extends Model
{
    //
    use SoftDeletes;
    protected $table = 'plan_task_job';

    protected $guarded = [];
}
