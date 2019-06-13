<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	protected $table = 'templates';
	
    protected $fillable = [
        'name', 'description', 'due_interval', 'due_unit',
    ];
    
    protected $hidden = [
		'created_at', 'updated_at',
    ];
    
    public function items()
    {
        return $this->hasMany('App\TemplateItem');
    }
}
