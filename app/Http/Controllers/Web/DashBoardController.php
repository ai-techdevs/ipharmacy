<?php

namespace App\Http\Controllers\Web;

use App\Models\Cdc;
use App\Models\Faq;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashBoardController extends Controller
{
    public function index(Request $request)
    {

        $forum = Forum::where(['status'=> 1])->orderBy('id', 'DESC')->first();
        $cdc = Cdc::where(['status'=> 1])->orderBy('id', 'DESC')->first();
        $faqs = Faq::where(['status'=> 1])->orderBy('id', 'DESC')->take(4)->get();

        return $faqs;

        return view('web.dashboard', compact('forum', 'faqs')) ;

    }

    
}
