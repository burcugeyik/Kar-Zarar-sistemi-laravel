<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Bu satır sayesinde masrafları kaydedebileceğiz
protected $fillable = [
    'user_id',
    'baslik',
    'tutar',
    'kategori'
];}