<?php

namespace App\Http\Requests\Post;

use App\Enums\PostStatus;
use App\Http\Requests\ApiRequest;

class ReviewRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'text' => ['required', 'string' ],
        ];
    }
}
