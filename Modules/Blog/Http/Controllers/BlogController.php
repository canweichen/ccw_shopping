<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Common\ArrayUtil;
use App\Models\User;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('blog::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request,$id)
    {
        User::find($id);
        //
        // $array = [
        //     ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
        //     ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
        //     ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
        //     ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
        //     ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
        // ];
        // $collect = collect($array)->unique('type');
        
        
        // return $collect->values()->toArray();
        //return ArrayUtil::arrayToString($array,'-');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
