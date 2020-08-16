<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $data['menu']       = 'catelouges';
        $data['subMenu']    = 'categories';
        $data['categories'] = Category::get(['id', 'name', 'discount', 'image', 'status']);
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
            dd($request->all());

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
                $category->section_id       = $request->section;
                $category->parent_id        = ($request->category == null) ? '0' : $request->category;
                $category->description      = $request->description;
                $category->meta_title       = $request->meta_title;
                $category->discount         = $request->discount;
                $category->status           = ($request->status == 'Active') ? '1' : '0';
                $category->meta_description = $request->meta_description;
                $category->meta_keywords    = $request->meta_keywords;
                $category->url              = Str::slug($request->name);

                if ($request->hasFile('image')) 
                {
                    $image = $request->file('image');
                    if (isset($image)) 
                    {
                        $fileName             = time() . '.' . $image->getClientOriginalExtension();
                        $extension            = strtolower($image->getClientOriginalExtension());
                        $existingFileLocation = public_path('images/categories/' . $category->image);
                        $locationToUpload     = public_path('images/categories/' . $fileName);
    
                        if (file_exists($existingFileLocation)) 
                        {
                            // dd($existingFileLocation);
                            // unlink($_SERVER['DOCUMENT_ROOT'] . $existingFileLocation);
                            @unlink($existingFileLocation);
                        }
                        if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'bmp') 
                        {
                            $image = Image::make($image)->resize(98, 98)->save($locationToUpload);
                            $category->image = $fileName;
                        } 
                        else 
                        {
                            Session::flash('error', 'Invalid image format');
                            return redirect('admin/categories');
                        }
                    }
                }

                $category->save();

                return redirect('admin/categories')->with('success', 'Category added successfully.');

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

    public function getCategoriesBySectionWise(Request $request)
    {
        $sectionId = $request->sectionId;

        $categories = Category::where(['section_id' => $sectionId])->get(['id', 'name']);
        
        if (! $categories->isEmpty()) 
        {
            $data['status']     = 200;
            $data['categories'] = $categories;
            return response()->json(['success' => $data]);
        }
        else 
        {
            $data['status']     = 400;
            return response()->json(['success' => $data]);
        }
    }
}
