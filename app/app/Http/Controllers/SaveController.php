<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaveController extends Controller
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
        $row_data = $request->input('json');
        $data_list = json_decode($row_data, true);
        echo var_export($data_list, true);
        return 'Complete!!';
    }
}
