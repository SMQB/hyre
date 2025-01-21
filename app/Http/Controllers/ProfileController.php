<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientProfile;

class ProfileController extends Controller
{
    public function index()
    {
        echo '<pre>';
        print_r('oooo');
        die;
        return ClientProfile::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:client_profiles',
        ]);

        return ClientProfile::create($request->all());
    }

    public function show(ClientProfile $client)
    {
        return $client;
    }

    public function update(Request $request, ClientProfile $client)
    {
        $client->update($request->all());
        return $client;
    }

    public function destroy(ClientProfile $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client deleted']);
    }
}
