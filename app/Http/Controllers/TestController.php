<?php

namespace App\Http\Controllers;

class TestController
{
    public function test()
    {
        return response()->json([
            "message" => "Hello authenticated User!"
        ]);
    }
}
