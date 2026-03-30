<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProjectMeta extends Model {
    protected $table    = 'project_meta';
    protected $fillable = ['project_id','meta_key','meta_value','is_highlighted','sort_order'];
    protected $casts    = ['is_highlighted' => 'boolean'];
}
