<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Document</title>
</head>
<body>
  <h3>Hello, A new comment has been added</h3>
  <h4>Show: {{ $comment['episode']['show']['name'] }} - Episode: {{ $comment['episode']['title'] }} </h4>
    <p>Comment:
    {{ $comment['comments'] }}
  </p>
  <p>By: {{ $comment['user']['first_name'] }}</p>
  <a href="{{ route('episode', array( $comment['episode']['show']['id'], Str::slug($comment['episode']['show']['name']), $comment['episode']['id'], Str::slug($comment['episode']['title']) )) }}#{{ $comment['id'] }}">Reply to this comment?</a>
</body>
</html>
