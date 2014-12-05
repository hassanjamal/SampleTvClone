@extends('master')

@section('content')

    <section>
        <h3 class="h4">{{{ $page->title }}}</h3>
        <hr>



        @if(strpos($page->content,'[ContactForm]') !== false)

            <?php

                echo str_replace('[ContactForm]', '
            <br><br>
            <form class="form-horizontal" method="post" action="">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Contact Us</legend>

                    '.Form::token().'

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="name">Name</label>
                      <div class="col-md-8">
                      <input id="name" name="name" type="text" class="form-control input-md">
                      </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="email">Email</label>
                      <div class="col-md-8">
                      <input id="email" name="email" type="email" class="form-control input-md">
                      </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="message">Message</label>
                      <div class="col-md-8">
                        <textarea class="form-control" id="message" name="message" rows="10"></textarea>
                      </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                      <div class="col-md-8 col-md-offset-2">
                        <button id="singlebutton" name="singlebutton" class="btn btn-primary">Send</button>
                      </div>
                    </div>

                </fieldset>
            </form>', $page->content);
        ?>

        @else
            {{ $page->content }}
        @endif


    </section>

@stop

