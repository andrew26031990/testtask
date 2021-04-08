<div class="table-responsive">
    <table class="table" id="books-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Description</th>
        <th>Image</th>
        <th>Author Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
            <td>{{ $book->description }}</td>
            <td><img src="{{ $book->image == null ? 'uploads/noimage.png' : $book->image }}" width="100" height="100" /></td>
            @foreach($authors as $author)
                @if($author->id == $book->author_id)
                    <td>{{ $author->name }}</td>
                @endif
            @endforeach
                <td width="120">
                    {!! Form::open(['route' => ['books.destroy', $book->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('books.show', [$book->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<a class="btn btn-primary float-right"
   href="javascript:void(0)" id="loadmore" lastId="{{$last_id}}">
    More books
</a>

