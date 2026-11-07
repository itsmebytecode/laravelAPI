<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function getStudentData()
    {
        // Fetch data from the external API safely from the server side
        $response = Http::get('https://brosebo.com/api/group/andam/students/grade');

        // Check if the request was successful
        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to connect to external API'
            ], 500);
        }

        // Return the JSON data back to your frontend JavaScript
        return $response->json();
    }
}
