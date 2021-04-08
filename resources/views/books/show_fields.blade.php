<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $books->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $books->description }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p><img src="{{ url($books->image) }}" width="100" height="100" /></p>
</div>

<!-- Author Id Field -->
<div class="col-sm-12">
    {!! Form::label('author_id', 'Author:') !!}
    @foreach($authors as $author)
        @if($author->id == $books->author_id)
            <br><p>{{ $author->name }}</p>
        @endif
    @endforeach
</div>

