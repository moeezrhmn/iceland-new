<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplates extends Model
{
    //use SoftDeletes;
    protected $table = 'email_templates';
    protected $fillable = ['template_name', 'template_subject', 'category_id', 'description','template_type','status', 'created_by'];

}
