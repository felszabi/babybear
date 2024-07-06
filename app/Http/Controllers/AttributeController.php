<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('attribute.set', ['attributes' => Attribute::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        // name 
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $attribute = Attribute::create([
            'name' => $request->name
        ]);
        return redirect()->route('attribute.set');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute, string $attributeid)
    {
        //

        return view('attribute.edit', ['attribute' => Attribute::find($attributeid)] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute, string $attributeid)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        
        $attribute = Attribute::find($attributeid);
        $attribute->name = $request->name;
        $attribute->save();
        return view('attribute.edit', ['attribute' => Attribute::find($attributeid)] );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute, string $attributeid)
    {
        //
        $attribute = Attribute::find($attributeid);
        $attribute->delete();

    }
}
