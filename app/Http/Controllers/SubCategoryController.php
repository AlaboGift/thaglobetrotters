<?php

namespace App\Http\Controllers;
use App\Enums\CategoryType;
use App\Enums\Pagination;
use App\Models\General\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Toastr;

class SubCategoryController extends Controller
{

    public function index(Request $request)
    {
        $title = 'Sub-Categories';

        $seachQuery = $request->search ? "%$request->search%" : '%%';
        $categories = Category::whereNotNull('parent_id')->orderBy('name')
            ->where('name', 'like', $seachQuery)
            ->dateFilter()
            ->statusFilter()
            ->paginate(Pagination::TABLE);

        return view('admin.sub-categories.index', compact('categories', 'title'));
    }

    public function create(Request $request)
    {
        $title = 'Create New Sub-Category';
        $category = new Category();
        $categories = Category::whereNull('parent_id')->get();

        // Fill model with old input
        if (!empty($request->old())) {
            $category->fill($request->old());
        }
        
        return view('admin.sub-categories.create', compact('category', 'title', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('categories', 'name')->whereNotNull('parent_id')],
            'description' => 'required',
            'category_id' => 'required|exists:categories,id'
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

        $parent = Category::find($data['category_id']);
        $data['slug'] = \Str::slug($data['name']);
        $data['parent_id'] = $parent->id;
        $data['category_type'] = $parent->category_type;

        Category::create($data);
        // redirect back with success message
        Toastr::success('Sub-Category Created successfully', 'Success');
        return redirect('admin/sub-categories');
    }

    public function edit($id)
    {
        $category = Category::findorfail($id);
        $title = "Edit Sub-Category: $category->name";
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.sub-categories.edit', compact('category', 'title', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $category = Category::findorfail($id);

        $data = $request->validate([
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'name' => ['required', Rule::unique('categories', 'name')
                            ->whereNot('id', $id)->whereNotNull('parent_id')],
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

        $parent = Category::find($data['category_id']);
        $data['slug'] = \Str::slug($data['name']);
        $data['parent_id'] = $parent->id;
        $data['category_type'] = $parent->category_type;
        $category->update($data);

        // redirect back with success message
        Toastr::success('Sub-Category Updated successfully', 'Success');
        return redirect('admin/sub-categories');
    }


    public function delete($id)
    {
        $category = Category::findorfail($id);

        if($category->packages()->count()){
            Toastr::error('Can not deleted sub-category with packages');
            return redirect()->back();
        }

        $category->delete();
        // redirect back with success message
        Toastr::success('Sub-Category deleted successfully');
        return redirect()->back();
    }
}
