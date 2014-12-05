<?php


class CommentController extends \BaseController {

     public function __construct()
     {
         Event::listen('user.comment', 'Authority\Mailers\UserMailer@newComment');
     }
    /**
     * Display a listing of the resource.
     * GET /comment
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * @param $type
     * @param $id
     * @internal param $showId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create($type, $id)
    {
        $comment = new Comment;

        if($type == 'show')
            $comment->show_id = $id;
        else
           $comment->episode_id = $id;

        $comment->user_id  = Sentry::getUser()->id;
        $comment->comments = Input::get('comment');

        if($comment->save())
        {
            Event::fire('user.comment', [
                       'comment'   => $comment
            ]);
            return Redirect::back()->with('message', 'Thanks for submitting comment');

        }
    }

    /**
     * @param $type
     * @param $id
     * @param $commentId
     * @internal param $showId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createComment($type, $id, $commentId)
    {
        $comment = new Comment;

        if($type == 'show')
            $comment->show_id   = $id;
        else
           $comment->episode_id   = $id;

        $comment->user_id   = Sentry::getUser()->id;
        $comment->parent_id = $commentId;
        $comment->comments  = Input::get('comment');

        if($comment->save())
        {
            Event::fire('user.comment', [
                       'comment'   => $comment
            ]);
            return Redirect::back()->with('message', 'Thanks for submitting comment');
        }
    }


    /**
     * Store a newly created resource in storage.
     * POST /comment
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /comment/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /comment/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /comment/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /comment/{id}
     *
     * @param $commentId
     * @return Response
     */
    public function destroy($commentId)
    {
        $deletedNode = Comment::find($commentId);
        if($deletedNode->delete())
        {
            return Redirect::back()->with('message', 'Comment has been deleted');
        }
    }

}
