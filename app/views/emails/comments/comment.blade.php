<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Document</title>
</head>
<body>
  <h3>Hello, A new comment has been added</h3>
  <h4>Show: {{ $comment['show']['name'] }}</h4>
    <p>Comment:
    {{ $comment['comments'] }}
  </p>
  <p>By: {{ $comment['user']['first_name'] }}</p>
  <a href="{{ route('show', array( $comment['show']['id'], Str::slug($comment['show']['name']) )) }}#{{ $comment['id'] }}">Reply to this comment?</a>
</body>
</html>
