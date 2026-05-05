<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function fileSystem(){
        // $path = Storage::disk('public')->putFileAs('test', request()->file('file')->store, 'test.txt');()
    }
}
