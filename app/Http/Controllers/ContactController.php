<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Phone;
use Illuminate\Http\Request;
use Log;

class ContactController extends APIController
{
    const DEFAULT_PHOTO = 'placeholder.png';
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = Contact::with(['phones'])->get();
        return $this->processGET($request, $contacts, function () use ($contacts) {
            return response()->json($contacts->toArray());
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function favorites(Request $request)
    {
        $contacts = Contact::with(['phones'])->where('favorite', '=', 1)->get();
        return $this->processGET($request, $contacts, function () use ($contacts) {
            return response()->json($contacts->toArray());
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = collect($request->json()->all());
        $dataPhones = ($data->only('phones')->first());
        $dataContact = $data->except(['phones'])->toArray();
        if(!array_key_exists('photo', $dataContact)) {
            $dataContact['photo'] = self::DEFAULT_PHOTO;
        }
        $contact = Contact::create($dataContact);
        return $this->processPOST($request, $contact, function () use ($contact, $dataPhones) {
            $contact->save();
            $phone = Phone::create([
                'label' => $dataPhones['label'],
                'number' => $dataPhones['number'],
                'contact_id' => $contact->id,
            ]);
            $phone->save();
            $contactNew = Contact::with(['phones'])->find($contact->id);
            Log::channel('api_log')->info('Contact: created', ['contact' => $contactNew]);
            return response()->json($contactNew->toArray());
        });
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $contact = Contact::with(['phones'])->find($id);
        return $this->processGET($request, $contact, function () use ($contact) {
            return response()->json($contact->toArray());
        });
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::with(['phones'])->find($id);
        $data = $request->json()->all();
        return $this->processPOST($request, $contact, function () use ($contact, $data) {
            $contact->update($data);
            $contact->save();
            Log::channel('api_log')->info('Contact: updated', ['contact' => $contact]);
            return response()->json($contact->toArray());
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $contact = Contact::with(['phones'])->find($id);
        return $this->processGET($request, $contact, function () use ($contact, $id) {
            Log::channel('api_log')->info('Contact: deleted', ['contact' => $contact]);
            $contact->delete();
            return response()->json('Deleted contact ' . $id . '.');
        });
    }
}
