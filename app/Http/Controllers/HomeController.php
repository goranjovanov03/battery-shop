<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['brand', 'category', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $categories = Category::with('children')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $newArrivals = Product::with(['brand', 'category', 'images'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Get dynamic homepage sections
        $homepageSections = HomepageSection::getActiveSections();

        // Get active hero slides for the slider
        $heroSlides = HeroSlide::getActiveSlides();

        // Get site settings
        $siteLogo = Setting::getValue('site_logo');
        $siteName = Setting::getValue('site_name', config('app.name'));

        return view('home', compact(
            'featuredProducts',
            'categories',
            'brands',
            'newArrivals',
            'homepageSections',
            'heroSlides',
            'siteLogo',
            'siteName'
        ));
    }
}