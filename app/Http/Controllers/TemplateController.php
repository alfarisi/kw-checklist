<?php

namespace App\Http\Controllers;

use App\Template;
use App\TemplateItem;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct()
    {
        //
    }
    
    public function index(Request $request) {
		if (!empty($request->query('page_limit'))) {
			$limit = $request->query('page_limit');
		} else {
			$limit = 10;
		}
		
		if (!empty($request->query('page_offset'))) {
			$offset = $request->query('page_offset');
		} else {
			$offset = 0;
		}
			
		$data = Template::all();
		$newdata = array();
		
		for ($i=0; $i<count($data); $i++) {
			$item = TemplateItem::where('template_id', $data[$i]['id'])->get();
			$newdata[$i] = (object)[
				'name'=>$data[$i]['name'],
				'checklist'=>(object) [
					'description'=>$data[$i]['description'],
					'due_interval'=>$data[$i]['due_interval'],
					'due_unit'=>$data[$i]['due_unit']
				],
				'items'=>$item
			];
		}
		
		$res = (object) [
			'links'=>(object)[
				'first' => '',
				'last' => '',
				'next' => '',
				'prev' => ''
			],
			'data'=>$newdata
		];
		$res->meta = (object) ['count'=>$limit, 'total'=>count($data)];
		return response()->json($res, 200);
	}

	public function detail($id) {
		$main = Template::find($id);
		$details = $main->items;
		$res = (object) [
			'type' => 'templates',
			'id' => ''.$id.'',
			'links' => (object) ['self' => url("/checklists/templates/{$id}")]
		];
		$res->attributes = (object)[
			'name' => $main['name'],
			'checklist' => (object) [
				'description' => $main['description'],
				'due_interval' => $main['due_interval'],
				'due_unit' => $main['due_unit']
			],
			'items' => $details
		];
		
		return response()->json(['data'=>$res], 200);
	}

	public function create(Request $request) {
		$req = json_decode($request->getContent());
		
		$db = new Template();
		$db->name = $req->data->attributes->name;
		$db->description = $req->data->attributes->checklist->description;
		$db->due_interval = $req->data->attributes->checklist->due_interval;
		$db->due_unit = $req->data->attributes->checklist->due_unit;
		
		if ($db->save()) {
			for ($i=0; $i<count($req->data->attributes->items); $i++) {
				$item = $req->data->attributes->items[$i];
				
				$dbdt = new TemplateItem();
				$dbdt->template_id = $db->id;
				$dbdt->description = $item->description;
				$dbdt->urgency = $item->urgency;
				$dbdt->due_interval = $item->due_interval;
				$dbdt->due_unit = $item->due_unit;
				$dbdt->save();
			}
		}
		
		$resp = $req;
		$resp->data->id = $db->id;

		return response()->json($resp, 201);
	}
	
	public function update($id, Request $request) {
		$req = json_decode($request->getContent());
		
		$db = Template::find($id);
		$db->name = $req->data->name;
		$db->description = $req->data->checklist->description;
		$db->due_interval = $req->data->checklist->due_interval;
		$db->due_unit = $req->data->checklist->due_unit;
		
		if ($db->save()) {
			TemplateItem::where('template_id', $id)->delete();
			
			for ($i=0; $i<count($req->data->items); $i++) {
				$item = $req->data->items[$i];
				
				$dbdt = new TemplateItem();
				$dbdt->template_id = $db->id;
				$dbdt->description = $item->description;
				$dbdt->urgency = $item->urgency;
				$dbdt->due_interval = $item->due_interval;
				$dbdt->due_unit = $item->due_unit;
				$dbdt->save();
			}
		}
		
		$resp = (object) ['id'=>$id, 'attributes'=>$req];

		return response()->json(['data'=>$resp], 200);
	}
	
	public function delete($id) {
		Template::find($id)->delete();
		return response('Deleted', 204);
	}
}
