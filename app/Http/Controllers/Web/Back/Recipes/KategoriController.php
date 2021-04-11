<?php

namespace App\Http\Controllers\Web\Back\Recipes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Resep\StoreKategoriRequest;
use App\Http\Requests\Resep\UpdateKategoriRequest;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kategoris = Kategori::orderBy('created_at','desc')->get();
        return view('recipes.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoriRequest $request)
    {
        $data = $request->all();

        $kategori = Kategori::create($data);
        return redirect()->route('resep.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('recipes.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoriRequest $request, $id)
    {
        $data = $request->all();
        $kategori = Kategori::find($id);
        $kategori->update($data);

        return redirect()->route('resep.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->forceDelete();
        return back();

    }
}
