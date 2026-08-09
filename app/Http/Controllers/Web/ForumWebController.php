<?php

namespace App\Http\Controllers\Web;

use App\Models\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumWebController extends Controller
{
    public function store(Request $request){
       $forum = Forum::create([
                    'name' => $request->name,
                    'user_id' => \Auth::user()->id,
                    'description' => $request->description,
                    'tag' => implode(',', explode(' ', $request->tag)),
                    'status' => 1,
                ]);

         return response()->json(['status'=> true, 'message' => 'Forum is created successfully.'], 200);

    }
}
