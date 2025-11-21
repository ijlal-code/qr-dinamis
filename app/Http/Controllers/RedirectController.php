<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use App\Models\QrVisit;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class RedirectController extends Controller
{
    public function handle($slug, Request $request)
    {
        // 1. Cari Link berdasarkan slug
        $link = QrLink::where('slug', $slug)->firstOrFail();

        // 2. Inisialisasi Agent detection
        $agent = new Agent();

        // 3. Rekam Data Pengunjung (Analytics)
        QrVisit::create([
            'qr_link_id' => $link->id,
            'ip_address' => $request->ip(),
            'device_type' => $agent->deviceType(), // mobile, tablet, desktop
            'os' => $agent->platform(),
            'browser' => $agent->browser(),
        ]);

        // 4. Update counter sederhana (opsional)
        $link->increment('visit_count');

        // 5. Redirect ke URL tujuan yang sebenarnya
        return redirect()->away($link->target_url);
    }
}
