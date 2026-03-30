<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Project extends Model {
    protected $fillable = ['project_key','icon','name','label','type','description','github_url','sort_order'];
    public function meta(): HasMany { return $this->hasMany(ProjectMeta::class)->orderBy('sort_order'); }
    public function tags(): HasMany { return $this->hasMany(ProjectTag::class)->orderBy('sort_order'); }
}
