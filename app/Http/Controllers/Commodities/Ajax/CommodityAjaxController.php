<?php

namespace App\Http\Controllers\Commodities\Ajax;

use App\Commodity;
use App\CommodityLocation;
use App\Http\Controllers\Controller;
use App\SchoolOperationalAssistance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommodityAjaxController extends Controller
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'description' => 'required',
        //     'image' => 'image|mimes:png,jpg|max:2048', // Adjust file types and size limit as needed
        // ]);

        $commodities = new Commodity();
        $commodities->school_operational_assistance_id = $request->school_operational_assistance_id;
        $commodities->commodity_location_id = $request->commodity_location_id;
        $commodities->item_code = $request->item_code;
        $commodities->name = $request->name;
        $commodities->brand = $request->brand;
        $commodities->material = $request->material;
        $commodities->year_of_purchase = $request->year_of_purchase;
        $commodities->condition = $request->condition;
        $commodities->quantity = $request->quantity;
        $commodities->price = $request->price;
        $commodities->price_per_item = $request->price_per_item;
        $commodities->note = $request->note;
        $commodities->save();

        // if ($request->hasFile('file')) {
        //     $image = $request->file('file');
        //     $imageName = time() . '_' . $image->getClientOriginalName();
        //     $imagePath = $image->storeAs('uploads', $imageName, 'public');
        //     $commodities->image_path = 'storage/' . $imagePath;
        // }

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodities], 200);
    }

    public function show($id)
    {
        $commodity = Commodity::findOrFail($id);

        $data = [
            'school_operational_assistance_id' => $commodity->school_operational_assistance->name,
            'commodity_location_id' => $commodity->commodity_location->name,
            'item_code' => $commodity->item_code,
            'name' => $commodity->name,
            'brand' => $commodity->brand,
            'material' => $commodity->material,
            // $commodity->date_of_purchase
            'year_of_purchase' => $commodity->year_of_purchase,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'price' => $commodity->indonesian_currency($commodity->price),
            'price_per_item' => $commodity->indonesian_currency($commodity->price_per_item),
            'note' => $commodity->note,
        ];

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $data], 200);
    }

    public function edit($id)
    {
        $commodity = Commodity::findOrFail($id);

        $commodity = [
            'school_operational_assistance_id' => $commodity->school_operational_assistance_id,
            'commodity_location_id' => $commodity->commodity_location_id,
            'item_code' => $commodity->item_code,
            'name' => $commodity->name,
            'brand' => $commodity->brand,
            'material' => $commodity->material,
            'year_of_purchase' => $commodity->year_of_purchase,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'price' => $commodity->price,
            'price_per_item' => $commodity->price_per_item,
            'note' => $commodity->note,
        ];

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => [
            'commodity' => $commodity,
            'school_operational_assistances' => SchoolOperationalAssistance::all(),
            'commodity_locations' => CommodityLocation::all(),
            'conditions' => [
                'Baik',
                'Kurang Baik',
                'Rusak Berat'
            ]
        ]], 200);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'description' => 'required',
        //     'image' => 'image|mimes:png,jpg|max:2048', // Adjust file types and size limit as needed
        // ]);

        $commodities = Commodity::findOrFail($id);

        $commodities->school_operational_assistance_id = $request->school_operational_assistance_id;
        $commodities->commodity_location_id = $request->commodity_location_id;
        $commodities->item_code = $request->item_code;
        $commodities->name = $request->name;
        $commodities->brand = $request->brand;
        $commodities->material = $request->material;
        $commodities->year_of_purchase = $request->year_of_purchase;
        $commodities->condition = $request->condition;
        $commodities->quantity = $request->quantity;
        $commodities->price = $request->price;
        $commodities->price_per_item = $request->price_per_item;
        $commodities->note = $request->note;
        $commodities->save();

        // Handle image upload
        // if ($request->hasFile('file')) {
        //     $image = $request->file('file');
        //     $imageName = time() . '_' . $image->getClientOriginalName();
        //     $imagePath = $image->storeAs('uploads', $imageName, 'public');
        //     $commodities->image_path = 'storage/' . $imagePath;
        // }

        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('uploads', 'public');
        //     $commodities->image_path = $imagePath;
        // }

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }

    public function destroy($id)
    {
        Commodity::findOrFail($id)->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}
