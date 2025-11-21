<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QrLinkController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'target_url' => ['required', 'url'],
        ]);

        $slug = $this->generateSlug();

        $link = QrLink::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'target_url' => $validated['target_url'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'QR berhasil disimpan dan siap dipakai.',
            'redirect_url' => route('qr.redirect', $link->slug),
            'slug' => $link->slug,
            'name' => $link->name,
        ], 201);
    }

    private function generateSlug(): string
    {
        do {
            $slug = Str::lower(Str::random(6));
        } while (QrLink::where('slug', $slug)->exists());

        return $slug;
    }
}
