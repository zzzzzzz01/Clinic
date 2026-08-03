<?php

namespace App\Services;

use App\Models\Faq;

class FaqService
{
    public function getAll()
    {
        $faqs = Faq::orderBy('sort_order', 'asc')->paginate(15);
        
        return $faqs->map(function($faq) {
            $statusConfig = $this->getStatusInfo($faq->status);
            
            return [
                'id' => $faq->id,
                'question' => $faq->question,
                'question_uz' => $faq->question_uz,
                'question_ru' => $faq->question_ru,
                'question_en' => $faq->question_en,
                'answer' => $faq->answer,
                'answer_uz' => $faq->answer_uz,
                'answer_ru' => $faq->answer_ru,
                'answer_en' => $faq->answer_en,
                'sort_order' => $faq->sort_order,
                'created_at' => $faq->created_at,
                'status' => $faq->status,
                'status_text' => $statusConfig['text'],
                'status_text_color' => $statusConfig['text_color'],
                'status_bg_color' => $statusConfig['bg_color'],
                'status_icon' => $statusConfig['icon'],
            ];
        });
    }

    public function getNextSortOrder()
    {
        return Faq::max('sort_order') + 1;
    }

    public function getById($raq)
    {
        $faq = Faq::findOrFail($raq);
        $statusConfig = $this->getStatusInfo($faq->status);
        
        return [
            'id' => $faq->id,
            'question' => $faq->question,
            'question_uz' => $faq->question_uz,
            'question_ru' => $faq->question_ru,
            'question_en' => $faq->question_en,
            'answer' => $faq->answer,
            'answer_uz' => $faq->answer_uz,
            'answer_ru' => $faq->answer_ru,
            'answer_en' => $faq->answer_en,
            'sort_order' => $faq->sort_order,
            'created_at' => $faq->created_at,
            'status' => $faq->status,
            'status_text' => $statusConfig['text'],
            'status_text_color' => $statusConfig['text_color'],
            'status_bg_color' => $statusConfig['bg_color'],
            'status_icon' => $statusConfig['icon'],
        ];
    }

    public function getStatusInfo($status)
    {
        if ($status == 1) {
            return [
                'bg_color' => '#e8f8f5',
                'text_color' => '#27ae60',
                'text' => __('words.active'),
                'icon' => 'fas fa-check-circle'
            ];
        } else {
            return [
                'bg_color' => '#fdedec',
                'text_color' => '#e74c3c',
                'text' => __('words.inactive'),
                'icon' => 'fas fa-times-circle'
            ];
        }
    }
}