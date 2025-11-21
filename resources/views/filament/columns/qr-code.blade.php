<div class="flex justify-center items-center py-2">
    {{-- 
       $getRecord() adalah fungsi bawaan Filament di dalam ViewColumn 
       untuk mengambil data baris (row) yang sedang diproses.
    --}}
    
    @if($getRecord()->slug)
        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)
            ->margin(1)
            ->generate(route('qr.redirect', $getRecord()->slug)) 
        !!}
    @else
        <span class="text-gray-400 text-xs">No Slug</span>
    @endif
</div>