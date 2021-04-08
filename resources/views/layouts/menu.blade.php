<li class="nav-item">
    <a href="{{ route('books.index') }}"
       class="nav-link {{ Request::is('books*') ? 'active' : '' }}">
        <p>Books</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('authors.index') }}"
       class="nav-link {{ Request::is('authors*') ? 'active' : '' }}">
        <p>Authors</p>
    </a>
</li>

