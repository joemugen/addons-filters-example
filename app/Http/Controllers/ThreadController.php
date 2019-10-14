<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadResource;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ThreadResource::collection(
            Thread::query()
                ->with([
                    'posts',
                    'posts.author'
                ])
                ->filter($request)
                ->sort($request->get('order'))
                ->paginate()
        );
    }
}
