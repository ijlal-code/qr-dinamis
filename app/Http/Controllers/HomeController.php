<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $links = QrLink::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard', [
            'links' => $links,
        ]);
    }
}
