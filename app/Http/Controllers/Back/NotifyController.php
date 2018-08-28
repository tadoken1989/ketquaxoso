<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\{
    Http\Controllers\Controller, Http\Requests\CategoryRequest, Http\Requests\NotifyRequest, Models\Category, Models\Notify
};

class NotifyController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notify = Notify::oldest('content')->get();

        return view('back.notify.index', compact ('notify'));
    }

    /**
     * Show the form for creating a new categorie.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.notify.create');
    }

    /**
     * Store a newly created notify in storage.
     *
     * @param  \App\Http\Requests\NotifyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotifyRequest $request)
    {
        $request->merge(['status' => $request->has('status')]);
        Notify::create($request->all());
        return redirect(route('notify.index'))->with('notify-ok', __('The notify has been successfully created'));
    }

    /**
     * Show the form for editing the specified categorie.
     *
     * @param  \App\Models\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function edit(Notify $notify)
    {
        return view('back.notify.edit', compact ('notify'));
    }

    /**
     * Update the specified notify in storage.
     *
     * @param  \App\Http\Requests\NotifyRequest  $request
     * @param  \App\Models\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function update(NotifyRequest $request, Notify $notify)
    {
        $request->merge(['status' => $request->has('status')]);

        $notify->update($request->all());

        return redirect(route('notify.index'))->with('notify-ok', __('The notify has been successfully updated'));
    }

    /**
     * Remove the specified notify from storage.
     *
     * @param  \App\Models\Notify  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notify $notify)
    {
        $notify->delete ();

        return response ()->json ();
    }
}
