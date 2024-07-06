<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeItem;
use App\Http\Requests\StoreAttributeItemRequest;
use App\Http\Requests\UpdateAttributeItemRequest;

class AttributeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $attributeid)
    {
        //
        return view('attributeitem.set', [
            'attribute' => Attribute::find($attributeid),
            'attributeitems' => AttributeItem::where('attributes_id', $attributeid)->get()
        ]);
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
    public function store(StoreAttributeItemRequest $request, string $attributeid)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $attributeitem = AttributeItem::create([
            'name' => $request->name,
            'attributes_id' => $attributeid
        ]);
        return $this::index($attributeid);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeItem $attributeItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeItem $attributeItem, string $itemid)
    {
        //
        return view('attributeitem.edit', ['attributeitem' => AttributeItem::find($itemid)] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeItemRequest $request, AttributeItem $attributeItem, string $itemid)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        
        $attributeitem = AttributeItem::find($itemid);
        $attributeitem->name = $request->name;
        $attributeitem->save();
        return $this::edit($attributeitem, $itemid);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeItem $attributeItem, string $itemid)
    {
        //
        $attributeitem = AttributeItem::find($itemid);
        $attributeitem->delete();
    }
}
