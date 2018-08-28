<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\{
    Http\Controllers\Controller, Http\Requests\CategoryRequest, Http\Requests\MenuRequest, Models\Category, Models\Menu
};

class MenuController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = Menu::oldest('content')->get();

        return view('back.menu.index', compact ('menu'));
    }

    /**
     * Show the form for creating a new categorie.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.menu.create');
    }

    /**
     * Store a newly created Menu in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $request->merge(['status' => $request->has('status')]);
        Menu::create($request->all());
        return redirect(route('menu.index'))->with('menu-ok', __('The Menu has been successfully created'));
    }

    /**
     * Show the form for editing the specified categorie.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view('back.menu.edit', compact ('menu'));
    }

    /**
     * Update the specified Menu in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $request->merge(['status' => $request->has('status')]);

        $menu->update($request->all());

        return redirect(route('menu.index'))->with('menu-ok', __('The Menu has been successfully updated'));
    }

    /**
     * Remove the specified Menu from storage.
     *
     * @param  \App\Models\Menu  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete ();

        return response ()->json ();
    }
}
