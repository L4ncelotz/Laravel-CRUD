<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 

    { 

        $query = Pet::query(); 

 

        // ค้นหาตามประเภท (species) 

        if ($request->filled('species')) { 

            $query->where('species', 'LIKE', "%{$request->species}%"); 

        } 

 

        // ค้นหาตามอายุ (age) 

        if ($request->filled('age')) { 

            $query->where('age', $request->age); 

        } 

 

        // ค้นหาตามสถานะ (status) 

        if ($request->filled('status')) { 

            $query->where('status', $request->status); 

        } 

 

        // ค้นหาตามช่วงราคา (price_min - price_max) 

        if ($request->filled('price_min')) { 

            $query->where('price', '>=', $request->price_min); 

        } 

        if ($request->filled('price_max')) { 

            $query->where('price', '<=', $request->price_max); 

        } 

 

        // ดึงข้อมูลทั้งหมดตามเงื่อนไข 

        $pets = $query->get(); 

 

        return response()->json([ 

            'success' => true, 

            'message' => count($pets) > 0 ? 'Data found' : 'No data available', 

            'count' => count($pets), 

            'data' => $pets 

        ], 200); 

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
    public function store(Request $request) 

    { 

        log::info($request->all()); 

        // validate ข้อมูล 

        $request->validate([ 

            'name' => 'required', 

            'species' => 'required', 

            'price' => 'required', 

            'status' => 'required', 

        ]); 

        // สร้างข้อมูลใหม่ จากข้อมูลที่ผ่านการตรวจสอบแล้ว 

        $pet = Pet::create($request->all()); 

 

        // return json response 

        return response()->json([ 

            'success' => true, 

            'message' => 'Pet created successfully', 

            'data' => $pet 

        ], 201); 

 

    } 

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet) 

    { 

        //  

        return response()->json([ 

            'success' => true, 

            'message' => 'Pet data found', 

            'data' => $pet 

        ], 200); 

    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
