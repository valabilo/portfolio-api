<?php
// ══════════════════════════════════════════════════════════
// portfolio-api/app/Models/Profile.php
// ══════════════════════════════════════════════════════════
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Profile extends Model {
    protected $table    = 'profile';
    protected $fillable = ['name','role','bio','location','email','phone','linkedin_url','github_url','available'];
    protected $casts    = ['available' => 'boolean'];
}
