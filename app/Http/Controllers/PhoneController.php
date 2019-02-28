<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phone;
use App\Contact;
use Log;

class PhoneController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $contactId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $contactId)
    {
        $contactRaw = Contact::with(['phones'])->find($contactId);
        return $this->processGET($request, $contactRaw, function () use ($contactRaw) {
            $contact = $contactRaw->toArray();
            return $contact['phones'];
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param $contactId
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function create(Request $request, $contactId)
    {
        $contactRaw = Contact::with(['phones'])->find($contactId);
        $data = $request->json()->all();
        return $this->processPOST($request, $contactRaw, function () use ($contactRaw, $data) {
            $phone = Phone::create([
                'label' => $data['label'],
                'number' => $data['number'],
                'contact_id' => $contactRaw->id,
            ]);
            $phone->save();
            Log::channel('api_log')->info('Phone: created', ['phone' => $phone]);

            return $phone->toArray();
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contactId, $id)
    {
        $phone = Phone::find($id);
        $data = $request->json()->all();
        return $this->processPOST($request, $phone, function () use ($phone, $data) {
            $phone->update($data);
            $phone->save();
            Log::channel('api_log')->info('Phone: updated', ['phone' => $phone]);
            return response()->json($phone->toArray());
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $contactId
     * @param  int $id
     * @return void
     */
    public function destroy(Request $request, $contactId, $id)
    {
        $phone = Phone::find($id);
        $this->processGET($request, $phone, function () use ($phone, $id) {
            Log::channel('api_log')->info('Phone: deleted', ['phone' => $phone]);
            $phone->delete();
            return response()->json('Deleted phone ' . $id . '.');
        });
    }
}
