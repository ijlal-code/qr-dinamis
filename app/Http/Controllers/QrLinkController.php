<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QrLinkController extends Controller
{
    public function create(): View
    {
        $links = QrLink::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('qr.create', [
            'links' => $links,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
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

        if (! $request->expectsJson()) {
            return redirect()
                ->route('qr-links.create')
                ->with('status', 'QR berhasil disimpan dan siap dipakai.');
        }

        return response()->json([
            'message' => 'QR berhasil disimpan dan siap dipakai.',
            'redirect_url' => route('qr.redirect', $link->slug),
            'slug' => $link->slug,
            'name' => $link->name,
        ], 201);
    }

    public function edit(QrLink $qrLink): View
    {
        $this->authorizeLink($qrLink);

        return view('qr.edit', [
            'link' => $qrLink,
        ]);
    }

    public function update(Request $request, QrLink $qrLink): RedirectResponse
    {
        $this->authorizeLink($qrLink);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'target_url' => ['required', 'url'],
        ]);

        $qrLink->update($validated);

        return redirect()
            ->route('dashboard')
            ->with('status', 'QR berhasil diperbarui.');
    }

    public function destroy(QrLink $qrLink): RedirectResponse
    {
        $this->authorizeLink($qrLink);

        $qrLink->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'QR berhasil dihapus.');
    }

    private function generateSlug(): string
    {
        do {
            $slug = Str::lower(Str::random(6));
        } while (QrLink::where('slug', $slug)->exists());

        return $slug;
    }

    private function authorizeLink(QrLink $qrLink): void
    {
        if ($qrLink->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
