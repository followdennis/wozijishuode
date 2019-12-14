<?php

namespace App\Models\Record;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FastRecord extends Model
{
    //
    use SoftDeletes;
    protected $table = 'fast_record';
    protected $guarded = [];

    public static $typeMap = [
        'link','question','plan','execute','technology','judge','invest','project','trouble','predict'
    ];

}
