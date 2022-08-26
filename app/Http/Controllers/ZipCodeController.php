<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZipCode;

class ZipCodeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($zip_code,Request $request)
    {
        $zip_code = ZipCode::where('zip_code',$zip_code)->with('federalEntity','settlements','municipality')->first();
        return is_null($zip_code) ? response()->json('Invalid zip code',400) : $zip_code;
    }
}
