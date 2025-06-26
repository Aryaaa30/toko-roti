<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all addresses for the authenticated user
        $addresses = auth()->user()->addresses;
        return response()->json($addresses);
    }
  
      /**
       * Show the form for creating a new address.
       *
       * @return \Illuminate\View\View
       */
      public function create()
      {
          return view('addresses.create');
      }
  
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_default' => 'boolean',
        ]);

        // Simpan label/alamat hasil reverse geocoding ke label dan address_line_1
        $label = $request->input('label', null);
        $address_line_1 = $request->input('address_line_1', null);
        if (!$label && $request->has('reverse_geocode')) {
            $label = $request->input('reverse_geocode');
        }
        if (!$address_line_1 && $request->has('reverse_geocode')) {
            $address_line_1 = $request->input('reverse_geocode');
        }
        $address = auth()->user()->addresses()->create([
            'label' => $label,
            'address_line_1' => $address_line_1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_default' => $request->is_default ?? false,
        ]);

        if ($request->is_default) {
            $this->setDefault($address);
        }

        return response()->json($address, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        // $this->authorize('update', $address); // Nonaktifkan policy sementara

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_default' => 'boolean',
        ]);
        $label = $request->input('label', null);
        $address_line_1 = $request->input('address_line_1', null);
        if (!$label && $request->has('reverse_geocode')) {
            $label = $request->input('reverse_geocode');
        }
        if (!$address_line_1 && $request->has('reverse_geocode')) {
            $address_line_1 = $request->input('reverse_geocode');
        }
        $address->update([
            'label' => $label,
            'address_line_1' => $address_line_1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_default' => $request->is_default ?? false,
        ]);
        if ($request->is_default) {
            $this->setDefault($address);
        }
        return response()->json($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = auth()->user()->addresses()->find($id);
        if (!$address) {
            return response()->json(['message' => 'Alamat tidak ditemukan atau bukan milik Anda.'], 404);
        }
        $address->delete();
        return response()->json(['message' => 'Alamat berhasil dihapus.']);
    }

    /**
     * Set the specified address as default.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function setDefault(Address $address)
    {
        // $this->authorize('update', $address); // Nonaktifkan policy sementara

        // Set all other addresses for the user to not default
        auth()->user()->addresses()->update(['is_default' => false]);

        // Set the selected address as default
        $address->update(['is_default' => true]);

        return response()->json($address);
    }
}
