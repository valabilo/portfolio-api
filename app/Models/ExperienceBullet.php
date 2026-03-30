<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ExperienceBullet extends Model {
    protected $fillable = ['experience_id','bullet_text','sort_order'];
}
