<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_uz',
        'question_ru',
        'question_en',
        'answer_uz',
        'answer_ru',
        'answer_en',
        'sort_order',
        'status',
    ];

    public function getQuestionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"question_$locale"};
    }

    public function getAnswerAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"answer_$locale"};
    }
}
