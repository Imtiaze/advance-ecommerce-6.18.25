<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;

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

        $data['sections'] = $section = Section::get(['id', 'name']);
        

        if ($request->isMethod('POST'))
        {
            // dd($request->all());
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
