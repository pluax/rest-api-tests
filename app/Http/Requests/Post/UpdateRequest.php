<?php

namespace App\Http\Requests\Post;

use App\Enums\PostStatus;
use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'title'         => ['nullable', 'string', 'max:255' ],
            'content'       => ['nullable','string'],
            'state'         => ['nullable', new Enum(PostStatus::class) ],
            'categoryId'    => ['nullable', 'numeric', 'exists:categories,id'],
        ];
    }
}
