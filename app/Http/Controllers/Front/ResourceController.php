<?php

namespace App\Http\Controllers\Front;

use App\Enums\ResourceType;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();

        $resources = Resource::query()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->with('tags')
            ->latest()
            ->paginate(24);

        return view('front.resources.index', [
            'resources' => $resources,
            'types' => ResourceType::cases(),
            'currentType' => $type,
        ]);
    }

    public function show(Resource $resource): View
    {
        $resource->load('tags');

        return view('front.resources.show', compact('resource'));
    }
}
