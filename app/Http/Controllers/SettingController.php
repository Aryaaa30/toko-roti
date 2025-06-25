<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua setting.
     */
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('settings.setting', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form tambah setting baru.
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     * Simpan setting baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'required|string',
        ]);

        Setting::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return redirect()->route('settings.index')->with('success', 'Setting berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail setting.
     */
    public function show(Setting $setting)
    {
        return view('settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form edit setting.
     */
    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     * Update setting.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key,' . $setting->id,
            'value' => 'required|string',
        ]);

        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return redirect()->route('settings.index')->with('success', 'Setting berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     * Hapus setting.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Setting berhasil dihapus.');
    }
}
