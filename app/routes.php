<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


App::bind('TvDb\Repo\TvDbClientInterface', 'TvDb\Repo\TvDbClient');

Route::model('shows', 'Show');
Route::model('sessions', 'ShowSession');
Route::model('episodes', 'Episode');
Route::model('links', 'EpisodeLink');


Route::pattern('noOfShows', '[0-9]+');
Route::pattern('hours', '[0-9]+');

// Route::group(array('prefix' => 'dev'), function()
// {
//     Route::get('fetch/all', array( 'as'=>'test', 'uses'=>'API@getAll'));
//     Route::get('fetch/{id}', array( 'as'=>'testShow', 'uses'=>'API@getShow'));
// });

Route::group(array('prefix' => 'cron'), function () {
    Route::get('{hours}/{hash}/{noOfShows?}', array('as' => 'fds', 'uses' => 'CronController@index'));
});

Route::group(array('prefix' => 'ajax'), function () {
    Route::get('/videoFrame', array('as' => 'videoFrame', function () {
        $videoFrame = new embedVideo();

        return $videoFrame->getVideoFrame(Input::get('url'), Input::get('alternateSize', null));
    }));

    Route::get('shows', [
        'as'   => 'ajaxShowSearch',
        'uses' => 'ShowController@getShowAjax'
    ]);


});

Route::get('/', array('as' => 'home', 'uses' => 'ShowController@index'));
Route::get('shows', array('as' => 'shows', 'uses' => 'ShowController@indexShows'));
Route::get('search', array('as' => 'search', 'uses' => 'ShowController@search'));
Route::get('genre/{id}-{slug}', array('as' => 'genre', 'uses' => 'ShowController@indexGenre'));
Route::get('year/{year}', array('as' => 'year', 'uses' => 'ShowController@indexYear'));

Route::get('requests', array('as' => 'requests', 'uses' => 'ShowController@indexRequests'));
Route::get('updates', array('as' => 'updates', 'uses' => 'EpisodeController@updates'));

Route::get('thumbnails/{type}/{showId}-{episodeId?}.jpg', array('as' => 'thumbnail', 'uses' => 'Thumbnail@show'));
Route::get('thumbnails/{type}/{showId}.jpg', array('as' => 'thumbnailShows', 'uses' => 'Thumbnail@showsThumbnail'));

Route::get('page/{slug}', array('as' => 'page', 'uses' => 'PageController@show'));
Route::post('page/{slug}', array('before' => 'csrf', 'uses' => 'PageController@send'));

Route::group(array('before' => 'isGuest'), function () {
    Route::get('register', array('as' => 'register', 'uses' => 'UsersController@create'));
    Route::post('register', array('before' => 'csrf', 'uses' => 'UsersController@store'));

    Route::get('login', array('as' => 'login', 'uses' => 'UsersController@login'));
    Route::post('login', array('before' => 'csrf', 'uses' => 'UsersController@loginCheck'));

    Route::get('oauth/twitter/activate/{sentryUser}', array('as' => 'twitterActivate', 'uses' => 'OAuthController@getTwitteractivate'));
    Route::post('oauth/twitter/activate/{sentryUser}', array('as' => 'postTwitterActivate', 'before' => 'csrf', 'uses' => 'OAuthController@postTwitteractivate'));

    Route::get('oauth/authorize/{serviceName}', array('as' => 'authorize', 'uses' => 'OAuthController@getAuthorize'));
    Route::get('oauth/authenticated/{serviceName}', array('as' => 'authenticated', 'uses' => 'OAuthController@getAuthenticated'));


    Route::controller('oauth', 'OAuthController');

});


// Route::group(array('before' => 'isGuest'), function()
// {
//     Route::get('register', array( 'as'=>'register', 'uses'=>'UsersController@create'));
//     Route::post('register', array( 'before'=>'csrf', 'uses'=>'UsersController@store'));

//     Route::get('login', array( 'as'=>'login', 'uses'=>'UsersController@login'));
//     Route::post('login', array( 'before'=>'csrf', 'uses'=>'UsersController@loginCheck'));
// });


Route::group(array('before' => 'isUser'), function () {
    Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController@index'));
    Route::post('profile', array('before' => 'csrf', 'uses' => 'UsersController@update'));

    Route::get('dashboard', array('as' => 'dashboard', 'uses' => 'UsersController@index'));

    Route::get('show/watchlist/add/{id}', array('as' => 'addToWatchlistShow', 'uses' => 'ShowController@addToWatchlistShow'));
    Route::get('show/watchlist/delete/{id}', array('as' => 'destroyWatchlistShow', 'uses' => 'ShowController@destroyWatchlistShow'));

    Route::get('show/watched/add/{id}', array('as' => 'addToWatchedShow', 'uses' => 'ShowController@addToWatchedShow'));
    Route::get('show/watched/delete/{id}', array('as' => 'destroyWatchedShow', 'uses' => 'ShowController@destroyWatchedShow'));

    Route::get('show/favorites/add/{id}', array('as' => 'addToFavoriteShow', 'uses' => 'ShowController@addToFavoriteShow'));
    Route::get('show/favorites/delete/{id}', array('as' => 'destroyFavoriteShow', 'uses' => 'ShowController@destroyFavoriteShow'));

    Route::get('show/rating/{id}-{rating}', array('as' => 'showRating', 'uses' => 'ShowController@addShowRating'));

    Route::get('watchlist/add/{id}', array('as' => 'addToWatchlist', 'uses' => 'EpisodeController@addToWatchlist'));
    Route::get('watchlist/delete/{id}', array('as' => 'destroyWatchlist', 'uses' => 'EpisodeController@destroyWatchlist'));

    Route::get('watched/add/{id}', array('as' => 'addToWatchedEpisode', 'uses' => 'EpisodeController@addToWatchedEpisode'));
    Route::get('watched/delete/{id}', array('as' => 'destroyWatched', 'uses' => 'EpisodeController@destroyWatched'));

    Route::get('favorites/add/{id}', array('as' => 'addToFavorite', 'uses' => 'EpisodeController@addToFavorite'));
    Route::get('favorites/delete/{id}', array('as' => 'destroyFavorite', 'uses' => 'EpisodeController@destroyFavorite'));

    Route::get('episode/rating/{id}-{rating}',
        array('as' => 'episodeRating', 'uses' => 'EpisodeController@addEpisodeRating'));


    Route::get('add-link/{id}', array('as' => 'addLink', 'uses' => 'LinkController@create'));
    Route::post('add-link/{id}', array('before' => 'csrf', 'uses' => 'LinkController@store'));

    Route::get('request-link/{id}', array('as' => 'requestLink', 'uses' => 'LinkController@request'));

    Route::get('link/{id}/vote/{vote}', array('as' => 'linkVote', 'uses' => 'LinkController@vote'));

    Route::post('comment/{type}-{id}', array('as' => 'postComment', 'uses' => 'CommentController@create'));
    Route::post('comment/{type}-{id}/{commentId}', array('as' => 'postCommentReply', 'uses' => 'CommentController@createComment'));

    Route::get('logout', array('as' => 'logout', 'uses' => 'UsersController@logout'));

});


Route::group(array('prefix' => 'admin', 'before' => 'isAdmin'), function () {
    // Dashborad
    Route::get('/', array('as' => 'admin', 'uses' => 'AdminController@index'));

    // Site configuration
    Route::get('configure', array('as' => 'admin.configure', 'uses' => 'AdminController@getConfigure'));
    Route::post('configure', array('as' => 'admin', 'uses' => 'AdminController@postConfigure'));


    Route::get('shows/search', array('as' => 'adminShowSearch', 'uses' => 'AdminShowsController@search'));
    Route::get('shows/create/tvdb', array('as' => 'admin.shows.create.tvdb', 'uses' => 'AdminShowsController@createFromTvDb'));
    Route::get('shows/create/search', array('as' => 'adminShowSearchNew', 'uses' => 'AdminShowsController@searchTvdb'));
    Route::get('shows/search', array('as' => 'adminShowSearch', 'uses' => 'AdminShowsController@search'));

    //fetch images from the TVDB
    Route::get('shows/{showId}/showImage', array('as' => 'adminShowImage', 'uses' => 'AdminShowsController@getShowImage'));
    Route::get('shows/{showId}/showEpisodesImage', array('as' => 'adminShowEpisodeImage', 'uses' => 'AdminShowsController@getShowEpisodesImage'));

    Route::get('shows/store/{showId}', array('as' => 'adminShowStore', 'uses' => 'AdminShowsController@storeTvdb'));
    Route::get('shows/delete/{showId}', array('as' => 'adminShowDelete', 'uses' => 'AdminShowsController@destroy'));
    Route::get('shows/update/{showId}', array('as' => 'adminShowUpdate', 'uses' => 'CronController@adminShowUpdate'));
    Route::resource('shows', 'AdminShowsController',['except' => ['show']]);

    Route::get('search_session', ['as' => 'admin.show.search.session', 'uses' => 'AdminShowsController@searchSession']);
    Route::post('search_session', ['as' => 'admin.show.search.postSession', 'uses' => 'AdminShowsController@postSearchSession']);
    Route::get('add_to_show_id', ['as' => 'admin.show.search.ajax', 'uses' => 'AdminShowsController@getAjaxShow']);

    // overriding default delete route in order to avoid creating a form to delete
    Route::get('shows/{shows}/sessions/{sessions}/destroy', ['as' => 'admin.shows.sessions.destroy', 'uses' => 'AdminSessionController@destroy']);
    Route::resource('shows.sessions', 'AdminSessionController', ['except' => ['destroy']]);

    Route::get('shows/{shows}/sessions/{sessions}/episodes/{episodes}/destroy', ['as' => 'admin.shows.sessions.episodes.destroy', 'uses' => 'AdminEpisodeController@destroy']);
    Route::resource('shows.sessions.episodes', 'AdminEpisodeController', ['except' => ['destroy', 'show']]);

    Route::resource('shows.sessions.episodes.links', 'AdminLinksController', ['except' => ['destroy']]);

    Route::get('links', array('as' => 'adminLinks', 'uses' => 'AdminLinksController@index'));
    Route::get('links/search', array('as' => 'adminLinkSearch', 'uses' => 'AdminLinksController@search'));
    Route::get('links/reported', array('as' => 'adminLinkUnapproved', 'uses' => 'AdminLinksController@unapproved'));
    Route::get('links/approve/{id}', array('as' => 'adminLinkApprove', 'uses' => 'AdminLinksController@approve'));
    Route::get('links/delete/{id}', array('as' => 'adminLinkDelete', 'uses' => 'AdminLinksController@destroy'));

   Route::get('episodes', array( 'as'=>'adminEpisodes', 'uses'=>'AdminEpisodesController@index'));
   Route::get('episodes/search', array('as'=>'adminEpisodeSearch','uses'=>'AdminEpisodesController@search'));
   Route::get('episodes/delete/{id}', array( 'as'=>'adminEpisodeDelete', 'uses'=>'AdminEpisodesController@destroy'));

    Route::get('users', array('as' => 'adminUsers', 'uses' => 'AdminUsersController@index'));
    Route::get('users/search', array('as' => 'adminUserSearch', 'uses' => 'AdminUsersController@search'));
    Route::get('users/delete/{id}', array('as' => 'adminUserDelete', 'uses' => 'AdminUsersController@destroy'));

    Route::get('pages', array('as' => 'adminPages', 'uses' => 'AdminPagesController@index'));
    Route::get('pages/search', array('as' => 'adminPageSearch', 'uses' => 'AdminPagesController@search'));
    Route::get('pages/create', array('as' => 'adminPageCreate', 'uses' => 'AdminPagesController@create'));
    Route::post('pages/create', array('before' => 'csrf', 'uses' => 'AdminPagesController@store'));
    Route::get('pages/edit/{id}', array('as' => 'adminPageEdit', 'uses' => 'AdminPagesController@edit'));
    Route::post('pages/edit/{id}', array('before' => 'csrf', 'uses' => 'AdminPagesController@update'));
    Route::get('pages/delete/{id}', array('as' => 'adminPageDelete', 'uses' => 'AdminPagesController@destroy'));


    Route::get('comment/{id}', array('as' => 'deleteComment', 'uses' => 'CommentController@destroy'));

    Route::get('logout', array('as' => 'adminLogout', 'uses' => 'AdminController@logout'));

});
// route for show
Route::get('{id}-{slug}', array('as' => 'show', 'uses' => 'ShowController@show'));
// route for episodes
Route::get('{showId}-{showSlug}/{id}-{slug}', array('as' => 'episode', 'uses' => 'EpisodeController@show'));


// Route::get('/', function()
// {
//     $content = file_get_contents("http://services.tvrage.com/feeds/full_show_info.php?sid=2930");


//     $result = Formatter::make($content, 'xml')->to_array();

//     if ( empty(Formatter::$errors) ) {
//         //show the results
//         return $result;
//     } else {
//         // Show the errors
//         print_r(Formatter::$errors);
//         return;
//     }


// });

function get_domain($link)
{
    $pslManager = new Pdp\PublicSuffixListManager();
    $parser     = new Pdp\Parser($pslManager->getList());
    $link       = $parser->parseUrl($link);

    return $link->host->registerableDomain;
}

/**
 * Calculate rating
 *
 * @param  object $ratings
 * @return Response
 */
function calculateRating($ratings)
{
    $total = "";
    $count = count($ratings);
    if ($count == 0) return $count;

    foreach ($ratings as $rating) {
        $total = $total + $rating->rating;
    }

    return $total / $count;
}


/**
 * Get time ago
 *
 * @param  object $date
 * @return Response
 */
function timeAgo($date)
{
    $total = "";
    $count = count($ratings);
    if ($count == 0) return $count;

    foreach ($ratings as $rating) {
        $total = $total + $rating->rating;
    }

    return $total / $count;
}


function countVotes($arr, $key)
{
    $count = 0;
    foreach ($arr as $row) {
        if ($row->vote == $key) {
            $count++;
        }
    }

    return $count;
}

function comments($comments)
{
    $final = array();
    foreach ($comments as $comment) {
        $final[$comment->depth][$comment->id] = $comment;
        // foreach ($childComments as $child)
        // {
        //     if($comment->id == $child->parent_id)
        //         $final[$comment->id]['child'][$child->id] = $child;
        //     // $final[$comment->id]['childs'] = comments($childComments, $childComments);
        // }
    }

    return $final;
}


function commentsView($cId, $type, $comments, $i = 0, $parent = null)
{

    $max = count($comments);
    if ($i == $max) return;

    foreach ($comments[$i] as $comment) {
        if ($comment->parent_id == $parent || $comment->parent_id == null) {
            ?>
            <li class="commentItem" id="<?php echo $comment->id; ?>">
                <div class="commenterImage">
                    <img src="http://www.gravatar.com/avatar/<?php echo md5($comment->user->email); ?>?s=80"/>
                </div>
                <div class="commentText">
                    <p class=""><?php echo $comment->comments; ?></p>

                    <div class="date sub-text">
                        by <?php echo ucfirst($comment->user->first_name); ?>,
                        on <?php echo date('jS F Y', strtotime($comment->created_at)); ?>
                        <span class="pull-right">
                            <span class="reply"><i class="fa fa-reply"></i> reply</span>
                            <?php if (Sentry::getUser()->isSuperUser()) : ?>
                                &nbsp;
                                <a href="<?php echo route('deleteComment', $comment->id) ?>" class="delete">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                <form action="<?php echo route('postCommentReply', array($type, $cId, $comment->id)); ?>" method="post"
                      class="clearfix replyBox" style="display:none;">
                    <div class="form-group">
                        <textarea class="form-control" name="comment" rows="3"
                                  style="background-color: #F9F9F9;"></textarea>
                    </div>
                    <input type="submit" value="Reply" class="btn btn-warning">
                </form>
                <ul class="commentList">
                    <?php
                    commentsView($cId, $type, $comments, $i + 1, $comment->id);
                    ?>
                </ul>

            </li>
        <?php
        }
    }
    $i++;

    return;
}

