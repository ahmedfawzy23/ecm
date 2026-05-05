<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::paginate(5);
        return view('admin.banner', compact('banners'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10592',
            'status' => 'boolean',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '-' . $image->getClientOriginalName();
            $path = $image->storeAs('images/banners', $name);
            Banner::create([
                'image' => $path,
                'status' => $request->status ?? false,
            ]);
        }
        return redirect()->back()->with('success', 'Banner created successfully');
    }
}
