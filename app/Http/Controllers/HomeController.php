<?php

namespace App\Http\Controllers;

use App\Enums\CategoryType;
use App\Models\General\Category;
use App\Models\Package;
use App\Utils\Constants;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Home';
        $worldPackages = Package::with('reviews')->where('category_type', CategoryType::INTERNATIONAL)->published()->limit(4)->get();
        $nigerianPackages = Package::with('reviews')->where('category_type', CategoryType::NIGERIAN)->published()->limit(4)->get();
        $topDestinations = Category::whereNotNull('parent_id')->where('top_destination', true)->latest('updated_at')->limit(4)->get();
        $popularPackages = Package::published()->limit(4)->get();
        return view('landing.index', compact('worldPackages', 'nigerianPackages', 'topDestinations', 'popularPackages'));
    }

    public function about()
    {
        $title = 'About Us';
        return view('landing.about', compact('title'));
    }

    public function contact()
    {
        $title = 'Contact Us';
        return view('landing.contact', compact('title'));
    }

    public function faqs()
    {
        $title = 'Frequently Asked Questions';
        return view('landing.faqs', compact('title'));
    }

    public function privacy()
    {
        $title = 'Privacy Policy';
        return view('landing.privacy', compact('title'));
    }

    public function terms()
    {
        $title = 'Terms & Conditions';
        return view('landing.terms', compact('title'));
    }

    public function packages(Request $request)
    {
        $title = "Packages";
        $packages = Package::published();

        if($request->search){
            $title = "Searched Packages";
            $seachQuery = "%$request->search%";
            $packages->where('name', 'like', $seachQuery)
                    ->orWhere('description', 'like', $seachQuery);
        }

        if($request->category){
            $category = Category::where('slug', $request->category)->first();
            $packages->where('sub_category_id', $category->id);
            $title = ucwords("$category->name Packages");
        }

        if($request->type){
            $type = strtoupper($request->type);
            $packages->where('category_type', $type);
            $title = ucwords(strtolower("$type Packages"));
        }

        $packages = $packages->dateFilter()->latest()->paginate(Constants::PAGINATION_PER_PAGE);
        return view('landing.packages', compact('title', 'packages'));

    }

    public function package($slug)
    {

        if($slug == "custom"){
            $title = "Custom Package";
            return view('landing.custom-package', compact('title'));
        }

        $package = Package::with('reviews')->where('slug', $slug)->first();

        if(!$package){
            Toastr::error('Invalid Package selected');
            redirect()->back();
        }

        $title = ucwords($package->name);
        $packages = Package::where(function ($query) use ($package) {
                        $query->where('category_id', $package->category_id)
                            ->orWhere('sub_category_id', $package->sub_category_id)
                            ->orWhere('category_type', $package->category_type);
                    })->where('id', '!=', $package->id)->latest()->take(4)->get();

        return view('landing.package', compact('package', 'title', 'packages'));
    }
}
