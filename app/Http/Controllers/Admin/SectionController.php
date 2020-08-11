<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $data['menu']     = 'catelouges';
        $data['subMenu']  = 'sections';
        $data['sections'] = Section::get(['id', 'name', 'status']);
        // dd($data);

        return view('admin.section.index', $data);
    }

    public function updateSectionStatus(Request $request)
    {
        $status    = $request->status;
        $sectionId = $request->sectionId;

        if ($status == 'Active') 
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }

        $data = Section::find($sectionId, ['id', 'status'])->update(['status' => $status]);

        if($data)
        {
            return response()->json(['statusCode' => 200, 'status' => $status, 'sectionId' => $sectionId]);
        }
    }
}
