<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $data['menu']       = 'catelouges';
        $data['subMenu']    = 'categories';
        $data['categories'] = Category::get(['id', 'name', 'status']);
        return view('admin.category.index', $data);
    }

    public function addCategory(Request $request)
    {
        $data = [];
        $data['menu']       = 'catelouges';
        $data['subMenu']    = 'categories';

        $data['sections']   = $section    = Section::get(['id', 'name']);
        $data['categories'] = $categories = Category::get(['id', 'name']);


        if ($request->isMethod('POST'))
        {
            // dd($request->all());

            $rules = array(
                'name'     => 'required',
                'discount' => 'nullable|numeric|regex:/^\d*(\.\d{2})?$/',
                'section'  => 'required',
                'status'   => 'required',
                'image'    => 'mimes:jpeg,png,jpg,gif,svg|image|max:10000'
            );
            $fieldNames = array(
                'name'     => 'Category Name',
                'discount' => 'Discount',
                'section'  => 'Section',
                'status'   => 'Status',
                'image'    => 'Category Image'
            );
    
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);
            if ($validator->fails()) 
            {
                return back()->withErrors($validator)->withInput();
            } 
            else 
            {
                $category = new Category();
                $category->name             = $request->name;
                $category->section_id         = $request->section;
                $category->parent_id        = ($request->category == null) ? '0' : $request->category;
                $category->description      = $request->description;
                $category->meta_title       = $request->meta_title;
                $category->discount         = $request->discount;
                $category->status           = ($request->status == 'Active') ? '1' : '0';
                $category->meta_description = $request->meta_description;
                $category->meta_keywords    = $request->meta_keywords;
                $category->save();

                return redirect()->back()->with('success', 'Category added successfully.');

            }
        }

        return view('admin.category.add', $data);
    }

    public function updateCategoryStatus(Request $request)
    {
        $status     = $request->status;
        $categoryId = $request->categoryId;

        if ($status == 'Active') 
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }

        $data = Category::find($categoryId, ['id', 'status'])->update(['status' => $status]);
        // dd($data);

        if($data)
        {
            return response()->json(
                [
                    'statusCode' => 200, 
                    'status' => $status, 
                    'categoryId' => $categoryId
                ]
            );
        }
    }
}
