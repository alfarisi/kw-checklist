<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct()
    {
        //
    }
    
    public function index() {
		$data = Template::all();
		return response($data);
	}

	public function detail($id) {
		$data = Template::where('id',$id)->get();
		return response ($data);
	}

	public function create(Request $request) {
		$dt = json_decode($request->getContent(), true);
		
		$data = new Template();
		$data->name = $dt['data']['attributes']['name'];
		$data->description = $dt['data']['attributes']['checklist']['description'];
		$data->due_interval = $dt['data']['attributes']['checklist']['due_interval'];
		$data->due_unit = $dt['data']['attributes']['checklist']['due_unit'];
		$data->save();

		return response('Berhasil Tambah Data');
	}

    //
}
