<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('display_order')->orderBy('company_name')->get();

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.form', ['client' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('clients', 'public');
        }

        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client added.');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.form', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('logo')) {
            if ($client->logo_path) {
                Storage::disk('public')->delete($client->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        if ($client->logo_path) {
            Storage::disk('public')->delete($client->logo_path);
        }
        $client->delete();

        return back()->with('success', 'Client removed.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'logo' => 'nullable|image|max:2048',
        ]);
        unset($data['logo']);
        $data['display_order'] = $data['display_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }
}
