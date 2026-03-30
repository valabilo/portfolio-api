<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ExperienceTag extends Model {
    protected $fillable = ['experience_id','tag_name','sort_order'];
}
