<?php

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;

class PostDTO
{
    public string $title;
    public string $content;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }
    
    public static function fromRequest($request)
    {
        return new self($request->title, $request->content);
    }
}