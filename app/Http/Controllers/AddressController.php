<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Address::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();

        $address             = new Address();

        $address->name       = $data['name'];
        $address->address1   = $data['address1'];
        $address->city       = $data['city'];
        $address->state      = $data['state'];
        $address->country    = $data['country'];
        $address->zip        = $data['zip'];
        $address->contact_id = $data['contact_id'];

        if (!empty($data['address2'])) {
            $address->address2 = $data['address2'];
        }
        if (!empty($data['description'])) {
            $address->description = $data['description'];
        }

        if ($address->save()) {
            $response = [
                'message' => 'Address created.',
                'address' => $address,
                'links' => [
                    'address' => 'http://crudstarter.app/api/v1/addresses/' . $address->id
                ]
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Address could not be created.',
                'address' => $address
            ];
            return response()->json($response, 304);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return $address;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $data = $request->input();

        if (!empty($data['name'])) {
            $address->name = $data['name'];
        }
        if (!empty($data['address1'])) {
            $address->address1 = $data['address1'];
        }
        if (!empty($data['city'])) {
            $address->city = $data['city'];
        }
        if (!empty($data['state'])) {
            $address->state = $data['state'];
        }
        if (!empty($data['country'])) {
            $address->country = $data['country'];
        }
        if (!empty($data['zip'])) {
            $address->zip = $data['zip'];
        }
        if (!empty($data['address2'])) {
            $address->address2 = $data['address2'];
        }
        if (!empty($data['description'])) {
            $address->description = $data['description'];
        }
        /* We'll never reassigne an address to another contact. */

        if ($address->save()) {
            $response = [
                'message' => 'Address updated.',
                'address' => $address,
                'links' => [
                    'address' => 'http://crudstarter.app/api/v1/addresses/' . $address->id
                ]
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Address could not be updated.',
                'address' => $address
            ];
            return response()->json($response, 304);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if ($address->delete()) {
            $response = [
                'message' => 'Address deleted.',
                'address' => $address,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Address could not be deleted.',
                'address' => $address,
                'links' => [
                    'address' => 'http://crudstarter.app/api/v1/addresses/' . $address->id
                ]
            ];
            return response()->json($response, 304);
        }
    }
}
