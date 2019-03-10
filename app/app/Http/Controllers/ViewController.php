<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function main(Request $request)
    {
        $type = $request->input('type');
        switch ($type) {
        case 'printed':
            $test = 'Printed list!!';
            break;
        default:
            $test = 'List!!';
        }
        return view(
            'list',
            compact('test')
        );
    }
}
