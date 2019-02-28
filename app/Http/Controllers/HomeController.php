<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    public $rules = [
        'name' => 'required',
        'surname' => 'required',
        'email' => 'required',
        'label' => 'required',
        'number' => 'required',
    ];

    public $messages =  [
        'name.required' => 'First name is required.',
        'surname.required' => 'Last name is required.',
        'email.required' => 'e-mail address is required.',
        'label.required' => 'Phone label is required.',
        'number.required' => 'Phone number is required.',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        $contactsRaw = $this->useAPI('contact');
        $contacts = json_decode($contactsRaw->getContent(), true);
        return view('home')->with(compact('contacts'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function favorites()
    {
        $contactsRaw = $this->useAPI('contact/favorites');
        $contacts = json_decode($contactsRaw->getContent(), true);
        return view('favorites')->with(compact('contacts'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function favoriteToggle($id)
    {
        $contactsRaw = $this->useAPI('contact/' . $id);
        if($contactsRaw->getStatusCode() == 200) {
            $contact = json_decode($contactsRaw->getContent(), true);
            $newFavorite = $contact['favorite'] == 1 ? 0 : 1;
            $postData = [ "favorite" => $newFavorite ];
            $response = $this->useAPI('contact/' . $id . '/update', 'POST', $postData);

            if($response->getStatusCode() == 200) {
                return redirect(config('app.url'))->with(['success' => 'Favorite flag updated.']);
            }
            \Log::error('Contact update error', ['response' => $response]);
            return abort(404);
        }
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $contact = $this->nullContact($request->old());
        $action = route('store');
        $title = 'Create';
        return view('edit')->with(compact('contact', 'action', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect('contact/create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token', 'label', 'number']);
        if($request->has('photo')) {
            $path = $request->file('photo')->store('photos');
            $data['photo'] = preg_replace('/^photos\//', '', $path);
        }
        $data['phones'] = [
            'label' => $request->get('label'),
            'number' => $request->get('number'),
        ];
        $data['favorite'] = $request->has('favorite') ? 1 : 0;
        $response = $this->useAPI('contact/create', 'POST', $data);

        if($response->getStatusCode() == 200) {
            return redirect(config('app.url'))->with(['success' => 'Contact created.']);
        }
        \Log::error('Contact create error', ['response' => $response]);
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function edit($id)
    {
        $contactsRaw = $this->useAPI('contact/' . $id);
        if($contactsRaw->getStatusCode() == 200) {
            $contact = json_decode($contactsRaw->getContent(), true);
            $action = config('app.url') . '/contact/' . $id . '/update';
            $title = 'Edit';

            return view('edit')->with(compact('contact', 'action', 'title'));
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $rules = collect($this->rules)->except(['label', 'number'])->toArray();
        $validator = Validator::make($request->all(), $rules , $this->messages);

        if ($validator->fails()) {
            return redirect('contact/'. $id .'/edit')
                ->withErrors($validator)
                ->withInput();
        }


        $data = $request->except(['_token', 'label', 'number']);
        if($request->has('photo')) {
            $path = $request->file('photo')->store('photos');
            $data['photo'] = preg_replace('/^photos\//', '', $path);
        }
        $data['favorite'] = $request->has('favorite') ? 1 : 0;


        $response = $this->useAPI('contact/' . $id . '/update', 'POST', $data);

        if($response->getStatusCode() == 200) {
            return redirect(config('app.url'))->with(['success' => 'Contact updated.']);
        }
        \Log::error('Contact update error', ['response' => $response]);
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact = $this->useAPI('contact/' . $id);
        if($contact->getStatusCode() == 200) {
            $response = $this->useAPI('contact/' . $id . '/destroy');

            if ($response->getStatusCode() == 200) {
                return redirect(config('app.url'))->with(['success' => 'Contact deleted.']);
            }
            \Log::error('Contact (id='. $id . ') destroy error', ['response' => $response]);
            return abort(404);
        }
        \Log::error('Contact (id='. $id . ') does not exist', ['response' => $contact]);
        return abort(404);
    }

    /**
     * @param $old
     * @return array
     */
    protected function nullContact($old)
    {
        return [
            'id' => $old['id'] ?? 0,
            'name' => $old['name'] ?? '',
            'surname' => $old['surname'] ?? '',
            'email' => $old['email'] ?? '',
            'favorite' => $old['favorite'] ?? '',
            'photo' => $old['photo'] ?? '',
            'label' => $old['label'] ?? '',
            'number' => $old['number'] ?? '',
            'phones' => [],

        ];
    }

    /**
     * @param $endpoint
     * @param string $httpMethod
     * @param array $postData
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    protected function useAPI($endpoint, $httpMethod = 'GET', $postData = [])
    {
        if($httpMethod === 'POST') {
            $req = request()->create('/api/v1/' . $endpoint, $httpMethod, [], [], [], [], json_encode($postData));
        } else {
            $req = request()->create('/api/v1/' . $endpoint, $httpMethod);
        }
        $req->headers->set('Accept', 'application/json');
        $req->headers->set('X-Authorization', config('app.key'));
        $res = app()->handle($req);

        return $res;
    }
}
