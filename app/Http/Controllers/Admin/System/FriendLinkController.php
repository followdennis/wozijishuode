<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class FriendLinkController extends AdminController
{
    //
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function index(){
        echo 'friend';
    }
}
