<?php
// portfolio-api/app/Models/Award.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = ['title', 'issuer', 'year', 'sort_order'];
}
