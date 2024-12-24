<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paste;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\Visibility;
use App\Enums\VisibilityEnum;

class ReportController extends Controller
{
    public function show(request $request, $short_link)
    {

        $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC )->value('id');

        $publicPastes = Paste::where('visibility_id', $publicVisibilityId)
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            })
            ->where('user_id', '!=', Auth::id())
             ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $paste = Paste::where('short_link', $short_link)->firstOrFail();
        $user = Auth::user();
        return view('pages/sendReportPage', compact('paste','publicPastes'));
    }

    public function send_report(Request $request,$short_link){

        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        Report::create([
            'paste_id' => $paste->id,
            'user_id' => $request->user_id,
            'reason' => $request->text,
        ]);

        return redirect()->route('report', ['short_link' => $short_link])->with('success', 'Жалоба успешно отправлена.');
    
    }
}
