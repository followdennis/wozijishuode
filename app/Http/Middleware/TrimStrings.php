<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/16
 * Time: 14:09
 */

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

class TrimStrings extends BaseTrimmer
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}