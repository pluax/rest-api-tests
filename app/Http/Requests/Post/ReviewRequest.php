<?php

namespace App\Http\Requests\Post;

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
