<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;


class HomeController extends Controller
{ 
    protected $types = [
        'docx' => 'Microsoft Word Document',
        'doc' => 'Microsoft Word Document',
        'pdf' => 'PDF File',
        'png' => 'PNG Image',
        'jpg' => 'JPG Image',
        'jpeg' => 'JPEG Image',
        'psd' => 'Photoshop File',
        'xls' => 'Microsoft Excel Document',
        'xlsx' => 'Microsoft Excel Document',
    ];


    public function index(Request $request)
    {
        $file_icons = [
            'Microsoft Word Document' => asset('images/word.png'),
            'Microsoft Word Document' => asset('images/word.png'),
            'PDF File' => asset('images/pdf.png'),
            'Microsoft Excel Document' => asset('images/excel.png'),
            'Microsoft Excel Document' => asset('images/excel.png'),
        ];

        if($request->has('sort_by')) {
            $files = File::orderBy($request->sort_by, $request->order_by)->get();
        } elseif($request->has('search')) {
            $files = File::where('name', 'like', '%'. $request->search .'%')->get(); 
        } else {
            $files = File::get();
        }
        $files = $files->all();
        $view = 'thumbnails';
        $images = [
            'PNG Image',
            'JPG Image',
            'JPEG Image'
        ];
        $data = [
            'files' => $files, 
            'view' => $request->has('view') ? $request->view : $view, 
            'images' => $images,
            'sort_by' => 'created_at',
            'order_by' => 'asc',
            'file_icons' => $file_icons
        ];
        if ($request->has('sort_by')) {
            $data['sort_by'] = $request->sort_by;
            $data['order_by'] = $request->order_by;
        }
        return view('welcome', $data);
    }
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $nameOnly = pathinfo($name, PATHINFO_FILENAME);
        $type = $file->getClientOriginalExtension();
        $type = array_key_exists($type, $this->types) ? $this->types[$type] : $type . ' File';
        $data = [
            'name' => $nameOnly,
            'type' => $type,
            'unique_name' => time() . $name
        ];

        $file->move(public_path('uploads/'. $type ), $data['unique_name']);
        $newFile = File::create($data);

        return redirect()->back();
    }
}
