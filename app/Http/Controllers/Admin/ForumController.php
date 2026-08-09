<?php

namespace App\Http\Controllers\Admin;

use App\Models\Forum;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use App\DataTables\ForumDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\ForumCommentDataTable;

class ForumController extends Controller
{
    public function index(ForumDataTable $dataTable) {
        return $dataTable->render('admin.forums.index');
    }

    public function show($id, ForumCommentDataTable $dataTable){
        $forum = Forum::findOrFail($id) ;

        return $dataTable->with('forum_id', $id)->render('admin.forums.show', ['forum'=> $forum]);
        // return view('admin.forums.show', compact('forum')) ;


    }

    public function deleteForumComment($id){
         $comment =   ForumComment::findOrFail($id) ;
         $comment->delete() ;

         return redirect()->back()->with('success', 'Comment has been deleted successfully.');


    }
}
