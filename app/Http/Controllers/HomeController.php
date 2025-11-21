<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $recentLinks = collect();

        if (Auth::check()) {
            $recentLinks = QrLink::query()
                ->where('user_id', Auth::id())
                ->latest()
                ->take(6)
                ->get();
        }

        return view('welcome', [
            'recentLinks' => $recentLinks,
        ]);
    }
}
