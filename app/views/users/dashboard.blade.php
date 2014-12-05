@extends('master')

@section('content')

    <h3>Dashboard</h3>
    <hr>

    <div class="row">


        <div class="col-md-4">
            <div class="profile">
                <img src="{{ 'http://www.gravatar.com/avatar/' . md5( $user->email ) . '?s=150' }}" alt="..." class="img-circle">
                <p>{{ $user->name }}</p>
                <p>{{ $user->email }}</p>
            </div>
            <ul class="list-group">
                <li class="list-group-item active"><a href="#settings" data-toggle="tab">Edit Setting</a></li>
                <li class="list-group-item"><a href="#favorites" data-toggle="tab">My Favorite</a></li>
                <li class="list-group-item"><a href="#watchlist" data-toggle="tab">My Watch List</a></li>
                <li class="list-group-item"><a href="#watchedlist" data-toggle="tab">My Watched List</a></li>
                <li class="list-group-item"><a href="#links" data-toggle="tab">My Links</a></li>
                <li class="list-group-item"><a href="#requests" data-toggle="tab">My Requests</a></li>
            </ul>
        </div>


        <div class="tab-content col-md-8">

            <div class="tab-pane active row" id="settings">
                <form action="{{ route('profile') }}" method="post" accept-charset="utf-8" class="form-horizontal" enctype="multipart/form-data">

                    {{ Form::token() }}

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="firstName">First Name: </label>
                            <input type="text" id="firstName" name="first_name" value="{{ $user->first_name }}" class="form-control" tabindex="1">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            {{ Form::select('gender', ['0'=> 'Male' , '1' => 'Female' , '3' => 'Not Telling'], $user->gender , ['class' => 'form-control', 'tabindex' => '3']) }}

                        </div>
                        <!-- <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control">
                        </div> -->
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <input type="password" id="password" name="password" class="form-control" tabindex="5">
                        </div>

                    </div>

                    <div class="col-md-6 col-md-offset-1">
                        <div class="form-group">
                            <label for="lastName">Last Name: </label>
                            <input type="text" id="lastName" name="last_name" value="{{ $user->last_name }}" class="form-control" tabindex="2">
                        </div>
                        <div class="form-group">
                            <label for="location">Location:</label>
                            <input type="text" id="location" name="location" value="{{ $user->location }}" class="form-control" tabindex="4">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Re-type Password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" tabindex="6">
                        </div>
                        <!-- <div class="form-group">
                            <label for="userfile">Upload Avatar:</label>
                            <input type="file" id="userfile" name="userfile" class="form-control">
                            <p class="help-block">Max size 1mb (120x120).</p>
                        </div> -->

                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="about">About me:</label>
                            <textarea rows="5" name="about" class="form-control" tabindex="7">{{ $user->about }}</textarea> </div>

                        <div class="form-group">
                            <input type="hidden" name="username" value="{{ $user->username }}">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane row" id="favorites">

                <h4>Shows</h4>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Shows</th>
                            <th>Added</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->favourite_shows as $favourite )
                            <tr>
                                <td>
                                    <a href="{{ route('show', array( $favourite->show->id, Str::slug($favourite->show->name) )) }}">
                                        {{ $favourite->show->name }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($favourite->created_at))->diffForHumans()  }}</td>
                                <td>
                                    <a href="{{ route('destroyFavoriteShow', $favourite->id ) }}" class="label label-danger" style="font-size:14px;"><span class="fa fa-trash-o"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4>Episodes</h4>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Episode</th>
                            <th>Added</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->favourites as $favourite )
                            <tr>
                                <td>
                                    <a href="{{ route('episode', array( $favourite->episode->show->id, Str::slug($favourite->episode->show->name), $favourite->episode->id, Str::slug($favourite->episode->title) )) }}">
                                        {{ $favourite->episode->title }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($favourite->created_at))->diffForHumans()  }}</td>
                                <td>
                                    <a href="{{ route('destroyFavorite', $favourite->id ) }}" class="label label-danger" style="font-size:14px;"><span class="fa fa-trash-o"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane row" id="watchlist">

                <h4>Shows</h4>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Shows</th>
                            <th>Added</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->watchlist_show as $watchlist )
                            <tr>
                                <td>
                                    <a href="{{ route('show', array( $watchlist->show->id, Str::slug($watchlist->show->name) )) }}">
                                        {{ $watchlist->show->name }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($watchlist->created_at))->diffForHumans()  }}</td>
                                <td>
                                    <a href="{{ route('destroyWatchlistShow', $watchlist->id ) }}" class="label label-danger" style="font-size:14px;"><span class="fa fa-trash-o"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4>Episodes</h4>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Episode</th>
                            <th>Added</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->watchlist as $watchlist )
                            <tr>
                                <td>
                                    <a href="{{ route('episode', array( $watchlist->episode->show->id, Str::slug($watchlist->episode->show->name), $watchlist->episode->id, Str::slug($watchlist->episode->title) )) }}">
                                        {{ $watchlist->episode->title }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($watchlist->created_at))->diffForHumans()  }}</td>
                                <td>
                                    <a href="{{ route('destroyWatchlist', $watchlist->id ) }}" class="label label-danger" style="font-size:14px;"><span class="fa fa-trash-o"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane row" id="watchedlist">

                <h4>Shows</h4>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Shows</th>
                            <th>Added</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->watched_show as $watched )
                            <tr>
                                <td>
                                    <a href="{{ route('show', array( $watched->show->id, Str::slug($watched->show->name) )) }}">
                                        {{ $watched->show->name }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($watched->created_at))->diffForHumans()  }}</td>
                                <td>
                                    <a href="{{ route('destroyWatchedShow', $watched->id ) }}" class="label label-danger" style="font-size:14px;"><span class="fa fa-trash-o"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4>Episodes</h4>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Episode</th>
                            <th>Added</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->watched as $watched )
                            <tr>
                                <td>
                                    <a href="{{ route('episode', array( $watched->episode->show->id, Str::slug($watched->episode->show->name), $watched->episode->id, Str::slug($watched->episode->title) )) }}">
                                        {{ $watched->episode->title }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($watched->created_at))->diffForHumans()  }}</td>
                                <td>
                                    <a href="{{ route('destroyWatched', $watched->id ) }}" class="label label-danger" style="font-size:14px;"><span class="fa fa-trash-o"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane row" id="links">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Episode</th>
                            <th>Link</th>
                            <!-- <th>Quality</th> -->
                            <!-- <th>Language</th> -->
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->episode_links as $episode_link )
                            <tr>
                                <td>
                                    <a href="{{ route('episode', array( $episode_link->episode->show->id, Str::slug($episode_link->episode->show->name), $episode_link->episode->id, Str::slug($episode_link->episode->title) )) }}">
                                        {{ $episode_link->episode->title }}
                                    </a>
                                </td>
                                <td>
                                    <img src="http://www.google.com/s2/favicons?domain_url={{ $episode_link->domain }}" alt="">
                                    &nbsp;
                                    <a href="{{ $episode_link->link }}" target="_blank" rel="nofollow">
                                        {{ ucfirst( $episode_link->domain ) }}
                                    </a>
                                </td>
                                <!-- <td>{{ $episode_link->quality }}</td> -->
                                <!-- <td>{{ $episode_link->lang }}</td> -->
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode_link->created_at))->diffForHumans()  }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane row" id="requests">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Episode</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $user->episode_link_requests as $episode_link_request )
                            <tr>
                                <td>
                                    <a href="{{ route('episode', array( $episode_link_request->episode->show->id, Str::slug($episode_link_request->episode->show->name), $episode_link_request->episode->id, Str::slug($episode_link_request->episode->title) )) }}">
                                        {{ $episode_link_request->episode->title }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode_link_request->created_at))->diffForHumans()  }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@stop
