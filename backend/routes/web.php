<?php
use Illuminate\Support\Facades\Route;
Route::get('/', fn()=>response()->json(['name'=>'Chess Morocco API','status'=>'ok']));
