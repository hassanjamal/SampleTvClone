@extends('admin.layout')

@section('content')

<style type="text/css" media="screen">
.center-block {
    float: none;
    margin-left: auto;
    margin-right: auto;
}

.input-group .icon-addon .form-control {
    border-radius: 0;
}

.icon-addon {
    position: relative;
    color: #555;
    display: block;
}

.icon-addon:after,
.icon-addon:before {
    display: table;
    content: " ";
}

.icon-addon:after {
    clear: both;
}

.icon-addon .fa {
    position: absolute;
    z-index: 2;
    right: 10px;
    font-size: 14px;
    width: 20px;
    margin-left: -2.5px;
    text-align: center;
    padding: 10px 0;
    top: 1px
}


.icon-addon.addon-sm .form-control {
    height: 30px;
    padding: 5px 28px 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    min-width: 320px;
}

.icon-addon.addon-sm .fa,
.icon-addon.addon-sm .fa {
    margin-left: 0;
    font-size: 12px;
    right: 5px;
    top: -1px
}

.icon-addon .form-control:focus + .fa,
.icon-addon:hover .fa,
.icon-addon .form-control:focus + .fa,
.icon-addon:hover .fa {
    color: #2580db;
}
</style>

<!-- include summernote css/js-->
{{ HTML::style('admin-assets/css/summernote.css') }}
{{ HTML::style('admin-assets/css/summernote-bs3.css') }}
{{ HTML::script('admin-assets/js/summernote.min.js') }}



        <div class="clearfix">
            <h3 class="pull-left" style="margin-top:0px">
                Edit Page: <a href="{{ route('page', $page->slug) }}" target="_blank">{{{ $page->title }}}</a>
            </h3>
        </div>

        <br><br>
        <div>
            <form class="form-horizontal" action="{{ route('adminPageEdit', $page->id) }}" method="post">
                {{ Form::token() }}
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="title">Title</label>
                      <div class="col-md-8">
                      <input id="title" name="title" type="text" class="form-control input-md" value="{{{ $page->title }}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="slug">Slug</label>
                      <div class="col-md-8">
                      <input id="slug" name="slug" type="text" class="form-control input-md" value="{{{ $page->slug }}}" disabled="disabled">
                      </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="content">Content</label>
                      <div class="col-md-8">
                        <textarea class="form-control" id="content" name="content" rows="15">{{ $page->content }}</textarea>
                        <span class="help-block">Please use "[ContactForm]" to represent contact form.</span>
                      </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                      <!-- <label class="col-md-4 control-label" for="singlebutton"></label> -->
                      <div class="col-md-8 col-md-offset-2">
                        <button id="save" name="save" class="btn btn-primary">Save Page</button>
                      </div>
                    </div>

                </fieldset>
            </form>

        </div>



<script type="text/javascript">
    $(document).ready(function() {
      $('#content').summernote({
          height: 400,                 // set editor height

          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor

      });
    });

</script>
@stop
