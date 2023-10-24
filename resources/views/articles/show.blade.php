@extends('layout')
@section('content')
<div class="card mt-5" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$article->short_desc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    <div class="flex">
      <a class="btn btn-primary btn-sm mr-1" href="/article/{{$article->id}}/edit" class="card-link">Edit article</a>
      <form action="/article/{{$article->id}}" method="post">
        @csrf
        @method("DELETE")
        <button class="btn btn-secondary btn-sm" type="submit">Delete</button>
      </form>
    </div> 
  </div>
</div>

<div class="center card-header">
  <h3 class="text-center">Comments</h3>
  @isset($_GET['res'])
  @if($_GET['res'] == 1)
  <div class="alert alert-success text-center">
    <p>Ваш комментарий успешно создан. Отправлен на модерацию</p>
  </div>
  @endif
  @endisset
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
          @foreach($errors->all() as $error)
          <ul>
              <li>{{$error}}</li>
          </ul>
          @endforeach
      </div>
      
      @endif
    <form class="form" action="/comment/store" method="post">
      @csrf
      <label class="form-label" for="title">
        Title
      </label>
        <input type="text" class="form-control" name="title" id="title">
      <label class="form-label mt-3" for="text">
        Text
      </label>
        <input type="text" class="form-control" name="text" id="text">
        <input type="hidden" name="article_id" value="{{$article->id}}">
        <button type="submit" class="btn btn-primary btn-sm mt-3" class="card-link">Save comment</button>
    </form>
  </div>
</div>


@foreach($comments as $comment)
<div class="card mb-2" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">{{$comment->title}}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$comment->text}}</h6>
    <div class="flex">
      @can('comment', $comment)
      <a class="btn btn-primary btn-sm mr-1" href="/comment/edit/{{$comment->id}}" class="card-link">Edit comment</a>
      <a class="btn btn-secondary btn-sm mr-1" href="/comment/delete/{{$comment->id}}" class="card-link">Delete comment</a>
      @endcan
    </div> 
  </div>
</div>
@endforeach
{{$comments->links()}}
@endsection