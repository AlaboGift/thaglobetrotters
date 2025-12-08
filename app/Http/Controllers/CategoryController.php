<?php

namespace App\Http\Controllers;
use App\Enums\CategoryType;
use App\Enums\Pagination;
use App\Models\General\Category;
use Illuminate\Http\Request;
use Toastr;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $title = 'Categories';

        $seachQuery = $request->search ? "%$request->search%" : '%%';
        $categories = Category::whereNull('parent_id')->orderBy('name')
            ->where('name', 'like', $seachQuery)
            ->dateFilter()
            ->statusFilter()
            ->paginate(Pagination::TABLE);

        return view('admin.categories.index', compact('categories', 'title'));
    }

    public function create(Request $request)
    {
        $title = 'Create New Category';
        $category = new Category();
        $category_types = CategoryType::selectables(); 

        // Fill model with old input
        if (!empty($request->old())) {
            $category->fill($request->old());
        }
        
        return view('admin.categories.create', compact('category', 'title', 'category_types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required'
        ]);

        if ($request->hasFile('photo')) {
            // validate file
            $request->validate([
                'photo' => 'mimes:jpeg,jpg,png,gif|required|max:20000',
            ]);

            $photo = photo("photo","uploads/","assets/");
            
            if ($photo) {
                $data['image_url'] = $photo;
            }
        }

        $data['slug'] = \Str::slug($data['name']);

        Category::create($data);
        // redirect back with success message
        Toastr::success('Category Created successfully', 'Success');
        return redirect('admin/categories');
    }

    public function edit($id)
    {
        $category = Category::findorfail($id);
        $title = "Edit Category: $category->name";
        $category_types = CategoryType::selectables(); 
        return view('admin.categories.edit', compact('category', 'title', 'category_types'));
    }


    public function update(Request $request, $id)
    {
        $category = Category::findorfail($id);

        $data = $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
            'description' => 'required'
        ]);

        if ($request->hasFile('photo')) {
            // validate file
            $request->validate([
                'photo' => 'mimes:jpeg,jpg,png,gif|required|max:20000',
            ]);

            $photo = photo("photo","uploads/","assets/");
            
            if ($photo) {
                $data['image_url'] = $photo;
            }
        }

        $data['slug'] = \Str::slug($data['name']);
        $category->update($data);

        // redirect back with success message
        Toastr::success('Category Updated successfully', 'Success');
        return redirect('admin/categories');
    }


    public function delete($id)
    {
        $category = Category::findorfail($id);

        if($category->packages()->count()){
            Toastr::error('Can not deleted category with packages');
            return redirect()->back();
        }

        $category->delete();
        // redirect back with success message
        Toastr::success('Category deleted successfully');
        return redirect()->back();
    }
}
