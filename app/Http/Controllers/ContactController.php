<?php

namespace App\Http\Controllers;

use DB;
use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->has('filters')) {
            $filters = json_decode($request->input('filters'));

            $query = DB::table('contacts');

            if (!empty($filters->categories)) {
                $query->whereIn('category_id', $filters->categories);
            }

            return $query->get();
        } else {
            return Contact::all();
        }
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

        $contact             = new Contact();

        $contact->first_name = $data['first_name'];

        if (!empty($data['last_name'])) {
            $contact->last_name  = $data['last_name'];
        }
        if (!empty($data['phone'])) {
            $contact->phone  = $data['phone'];
        }
        if (!empty($data['email'])) {
            $contact->email  = $data['email'];
        }
        if (!empty($data['description'])) {
            $contact->description  = $data['description'];
        }
        if (!empty($data['date_of_birth'])) {
            $contact->date_of_birth  = $data['date_of_birth'];
        }
        if (!empty($data['category_id'])) {
            $contact->category_id  = $data['category_id'];
        } else {
            $contact->category_id = 1; // default Uncategorized category.
        }

        if ($contact->save()) {

            $response = [
                'message' => 'Contact created.',
                'contact' => $contact,
                'links' => [
                    'contact' => 'http://crudstarter.app/api/v1/contacts/' . $contact->id
                ]
            ];

            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Contact could not be created.',
                'contact' => $contact
            ];

            return response()->json($response, 304);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->input();

        if (!empty($data['first_name'])) {
            $contact->first_name  = $data['first_name'];
        }
        if (!empty($data['last_name'])) {
            $contact->last_name  = $data['last_name'];
        }
        if (!empty($data['phone'])) {
            $contact->phone  = $data['phone'];
        }
        if (!empty($data['email'])) {
            $contact->email  = $data['email'];
        }
        if (!empty($data['description'])) {
            $contact->description  = $data['description'];
        }
        if (!empty($data['date_of_birth'])) {
            $contact->date_of_birth  = $data['date_of_birth'];
        }
        if (!empty($data['category_id'])) {
            $contact->category_id  = $data['category_id'];
        }

        if ($contact->save()) {
            $response = [
                'message' => 'Contact updated.',
                'contact' => $contact,
                'links' => [
                    'contact' => 'http://crudstarter.app/api/v1/contacts/' . $contact->id
                ]
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Contact could not be updated.',
                'contact' => $contact
            ];

            return response()->json($response, 304);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if ($contact->delete()) {
            $response = [
                'message' => 'Contact deleted.',
                'contact' => $contact,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Contact could not be deleted',
                'contact' => $contact,
                'links' => [
                    'contact' => 'http://crudstarter.app/api/v1/contacts/' . $contact->id
                ]
            ];

            return response()->json($response, 304);
        }
    }
}
