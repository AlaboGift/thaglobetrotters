<?php

namespace App\Http\Controllers;
use App\Enums\CategoryType;
use App\Enums\Pagination;
use App\Enums\Status;
use App\Models\General\Category;
use App\Models\Package;
use App\Services\ImageService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PackageController extends Controller
{

    protected $imageService;

    public function __construct(
        ImageService $imageService
    )
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $title = ucwords(strtolower($request->type.' Packages'));
        $layout = Session::get('layout', 'grid');
        $pagination = $layout == 'grid' ? Pagination::CARD : Pagination::TABLE;
        $seachQuery = $request->search ? "%$request->search%" : '%%';
        $type = $request->type;
        $packages = Package::orderBy('name')
            ->where('name', 'like', $seachQuery)
            ->when(request('type'), function ($query, $type) {
                return $query->where('category_type', $type);
            })->dateFilter()
            ->statusFilter()
            ->paginate($pagination);

        return view('admin.packages.index', compact('packages', 'title', 'layout'));
    }

    public function create(Request $request)
    {
        $title = 'Create '.ucwords(strtolower($request->type.' Package'));
        $type = $request->type;
        $package = new Package();
        $category_types = CategoryType::getValues();
        $categories = Category::whereNull('parent_id')
            ->when($type && $type !== 'CURATED', function ($query) use ($type) {
                $query->where('category_type', $type);
            })->get();
        
        $subcategories = Category::whereNotNull('parent_id')
            ->when($type && $type !== 'CURATED', function ($query) use ($type) {
                $query->where('category_type', $type);
            })->get();

        // Fill model with old input
        if (!empty($request->old())) {
            $package->fill($request->old());
        }
        
        return view('admin.packages.create', compact('package', 'title', 'categories', 'type', 'category_types', 'subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|string|max:255",
            "category_type" => "required|string",
            "category" => "required|integer",
            "sub_category" => "required|integer",
            "price" => "required|numeric",
            "description" => "required|string",
            "included" => "nullable|string",
            "excluded" => "nullable|string",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "start" => "required|string|max:255",
            "in_between" => "nullable|string",
            "end" => "required|string|max:255",
            "titles" => "required|array",
            "titles.*" => "required|string",
            "descriptions" => "required|array",
            "descriptions.*" => "required|string",
        ]);
    

        $data['slug'] = Str::slug($data['title']);
        $data['name'] = $data['title'];
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $data['status'] = Status::INACTIVE;
        $package = Package::create($data);
    
        $itineraries = [];
        for ($i = 0; $i < count($request->titles); $i++) {
            $itineraries[] = [
                'package_id' => $package->id,
                'title' => $request->titles[$i],
                'description' => $request->descriptions[$i],
            ];
        }
    
        $package->itineraries()->insert($itineraries);
        Toastr::success('Package Created successfully', 'Success');
        return redirect("admin/packages/images/{$package->id}");
    }

    public function edit(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $title = 'Edit : '.ucwords(strtolower($package->name));
        $type = $request->type;
        $category_types = CategoryType::getValues();
        $categories = Category::whereNull('parent_id')->when(request('type'), function ($query, $type) {
            return $query->where('category_type', $type);
        })->get();

        $subcategories = Category::whereNotNull('parent_id')->when(request('type'), function ($query, $type) {
            return $query->where('category_type', $type);
        })->get();

        // Fill model with old input
        if (!empty($request->old())) {
            $package->fill($request->old());
        }
        
        return view('admin.packages.edit', compact('package', 'title', 'categories', 'type', 'category_types', 'subcategories'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "title" => "required|string|max:255",
            "category_type" => "required|string",
            "category" => "required|integer",
            "sub_category" => "required|integer",
            "price" => "required|numeric",
            "description" => "required|string",
            "included" => "nullable|string",
            "excluded" => "nullable|string",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "start" => "required|string|max:255",
            "in_between" => "nullable|string",
            "end" => "required|string|max:255",
            "titles" => "required|array",
            "titles.*" => "required|string",
            "descriptions" => "required|array",
            "descriptions.*" => "required|string",
        ]);

        $package = Package::findOrFail($id);
        $data['slug'] = Str::slug($data['title']);
        $data['name'] = $data['title'];
        $data['category_id'] = $data['category'];
        $data['sub_category_id'] = $data['sub_category'];
        $package->update($data);
    
        $itineraries = [];
        for ($i = 0; $i < count($request->titles); $i++) {
            $itineraries[] = [
                'package_id' => $package->id,
                'title' => $request->titles[$i],
                'description' => $request->descriptions[$i],
            ];
        }
    
        $package->itineraries()->delete();
        $package->itineraries()->insert($itineraries);

        // redirect back with success message
        Toastr::success('Package Updated successfully', 'Success');
        return redirect('admin/packages');
    }


    public function delete($id)
    {
        $package = Package::find($id);

        if(!$package){
            Toastr::error('Package not found');
            return back();
        }

        if($package->bookings()->count()){
            Toastr::error('Can not delete package');
            return redirect()->back();
        }

        $package->delete();
        Toastr::success('Package deleted successfully');
        return redirect()->back();
    }

    public function publish($id){
        $package = Package::find($id);

        if(!$package){
            Toastr::error('Package not found');
            return back();
        }

        $actioned = 'published';
        $status = Status::ACTIVE;

        if($package->status == Status::ACTIVE){
            $actioned = 'unpublished';
            $status = Status::INACTIVE;
        }

        $package->update(['status' => $status]);
        Toastr::success("Package $actioned successfully");
        return redirect()->back();
    }

    public function images($id)
    {
        $package = Package::findOrFail($id);
        $title = ucwords(strtolower($package->name)). " : Images";
        return view('admin.packages.images', compact('package', 'title'));
    }

    public function updateImages(Request $request, $id)
    {
        // validate that fileInput is an image
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $package = Package::findOrFail($id);
        $this->imageService->imageHandler($package, $request->file('file'));
        Toastr::success('Image uploaded successfully');
        return back();
    }

    public function deleteImage($id)
    {
        $this->imageService->deleteFile($id);
        Toastr::success('Image deleted successfully');
        return back();
    }


    public function defaultImage($id)
    {
        $this->imageService->default($id);
        Toastr::success('Image set as default successfully');
        return back();
    }

    public function setLayout($type)
    {
        Session::put('layout', $type);
        Toastr::success("Layout switched to {$type} successfully");
        return back();
    }
}
