<?php

namespace App\Http\Requests\Post;

use App\Enums\PostStatus;
use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rules\Enum;

class PostRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255' ],
            'content'       => ['string'],
            'thumbnail'     => ['image', 'max:500'],
            'state'         => ['required', new Enum(PostStatus::class) ],
            'categoryId'    => ['numeric'],
        ];
    }
}
