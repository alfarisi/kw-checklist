<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateItem extends Model
{
	protected $table = 'templates_items';
	
    protected $fillable = [
        'template_id', 'description', 'urgency', 'due_interval', 'due_unit',
    ];
    
    protected $hidden = [
		'id', 'template_id', 'created_at', 'updated_at',
    ];
}
