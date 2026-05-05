<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
        public function index()
    {
        $faqs = Faqs::paginate(5);
        return view('admin.faqs', compact('faqs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

            Faqs::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'status' => $request->status ?? false,
            ]);
        return redirect()->back()->with('success', 'FAQ created successfully');
    }
}
