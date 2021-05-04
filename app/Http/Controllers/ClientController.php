<?php

namespace App\Http\Controllers;

//use Redirect;
use Storage;
use Inertia\Inertia;
use App\Models\Client;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Clients/Index',['clients'=>Client::paginate(10)
        ->withQueryString()
        ->through(function ($client){
            return[
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'avatar' => $client->avatar,
                'email' => $client->email
            ];
        })]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return Inertia::render("Clients/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request,[
            'first_name' => ['required'],
            'last_name' => ['required'],
            'avatar'=>['required'],
            'email' => ['required','email']
        ]);

        $client = new Client();
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
       
        $file = request()->file('avatar');
        $path = $file->store('images', ['disk' => 'public']);
        
        $client->avatar = $path;
        $client->save();
       return Redirect::route('clients.index')->with('success', 'Client created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if (Storage::disk('public')->exists($client->avatar)) {
           $imagePreview = Storage::disk('public')->get($client->avatar);
        }

        return Inertia::render("Clients/Edit",[
            'client' => [
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'email' => $client->email,
                'avatar' => '/'.$client->avatar,
            ]
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request,[
            'first_name' => ['required'],
            'last_name' => ['required'],
            'avatar'=>['required'],
            'email' => ['required', 'email']
        ]);

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;

        if(request()->file('picture'))
        {
            $file = request()->file('picture');
            $path = $file->store('images', ['disk' => 'public']);
            $client->avatar = $path;
        }

        $client->update();
       
       return Redirect::route('clients.index')->with('success', 'Client updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //

        $client->delete();

        return Redirect::back()->with('success', 'Client deleted.');
    }
}
