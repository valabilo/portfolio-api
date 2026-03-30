<?php
// portfolio-api/app/Models/Education.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table    = 'education';
    protected $fillable = ['type', 'title', 'institution', 'year', 'sort_order'];
}
