<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Faqs;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get();
        $categories = Category::with('subCategories')->active()->get();
        return view('customer.index')->with('banners', $banners)->with('categories', $categories);
    }
    public function faqs()
    {
        $banners = Banner::active()->get();
        $categories = Category::with('subCategories')->active()->get();
        $faqs = Faqs::active()->get();
        return view('customer.faqs')->with('banners', $banners)->with('faqs', $faqs)->with('categories', $categories);
    }
    public function help()
    {
        $banners = Banner::active()->get();
        $categories = Category::with('subCategories')->active()->get();
        return view('customer.help')->with('banners', $banners)->with('categories', $categories);
    }
    public function support()
    {
        $banners = Banner::active()->get();
        $categories = Category::with('subCategories')->active()->get();
        return view('customer.support')->with('banners', $banners)->with('categories', $categories);
    }
}
