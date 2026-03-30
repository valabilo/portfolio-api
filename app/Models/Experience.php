<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Experience extends Model {
    protected $fillable = ['issue_key','title','sub_location','status','type','date_range','sort_order'];
    public function bullets(): HasMany { return $this->hasMany(ExperienceBullet::class)->orderBy('sort_order'); }
    public function tags(): HasMany    { return $this->hasMany(ExperienceTag::class)->orderBy('sort_order'); }
}
