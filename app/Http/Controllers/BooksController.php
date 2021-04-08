<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBooksRequest;
use App\Http\Requests\UpdateBooksRequest;
use App\Models\Authors;
use App\Models\Books;
use App\Repositories\AuthorsRepository;
use App\Repositories\BooksRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;
use Validator;
use Response;

class BooksController extends AppBaseController
{
    /** @var  BooksRepository */
    private $booksRepository;
    private $authorsRepository;

    public function __construct(BooksRepository $booksRepo, AuthorsRepository $authorsRepo)
    {
        $this->booksRepository = $booksRepo;
        $this->authorsRepository = $authorsRepo;
    }

    /**
     * Display a listing of the Books.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $books = $this->booksRepository->paginate(5);
        $count = count($books);
        $last_id = $books[$count-1]->id;
        $authors = $this->authorsRepository->all();
        return view('books.index', compact('books', 'authors', 'last_id'));
    }

    /**
     * Show the form for creating a new Books.
     *
     * @return Response
     */
    public function create()
    {
        $authors = Authors::pluck('name', 'id');
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created Books in storage.
     *
     * @param CreateBooksRequest $request
     *
     * @return Response
     */
    public function store(CreateBooksRequest $request)
    {
        $input = $request->all();

        $book = $this->booksRepository->create([
            'title' => $input['title'],
            'description' => $input['description'],
            'author_id' => $input['author_id'],
        ]);

        if($request->hasFile('image')){
            $image = $this->storeFile($request);
            $this->booksRepository->update(['image' => 'uploads/'.$image] ,$book->id);
        }

        Flash::success('Book saved successfully.');

        return redirect(route('books.index'));
    }

    public function storeFile($request){
        $dateTime = date('Ymd_His');
        $file = $request->file('image');
        $fileName = $dateTime . '-' . $file->getClientOriginalName();
        $savePath = public_path('/uploads/');
        $file->move($savePath, $fileName);
        return $fileName;
    }

    /**
     * Display the specified Books.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $books = $this->booksRepository->find($id);

        if (empty($books)) {
            Flash::error('Books not found');

            return redirect(route('books.index'));
        }

        $authors = $this->authorsRepository->all();
        return view('books.show', compact('books', 'authors'));
    }

    /**
     * Show the form for editing the specified Books.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $books = $this->booksRepository->find($id);

        if (empty($books)) {
            Flash::error('Books not found');

            return redirect(route('books.index'));
        }

        return view('books.edit')->with('books', $books);
    }

    /**
     * Update the specified Books in storage.
     *
     * @param int $id
     * @param UpdateBooksRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBooksRequest $request)
    {
        $books = $this->booksRepository->find($id);

        if (empty($books)) {
            Flash::error('Books not found');

            return redirect(route('books.index'));
        }

        $books = $this->booksRepository->update($request->all(), $id);

        Flash::success('Books updated successfully.');

        return redirect(route('books.index'));
    }

    /**
     * Remove the specified Books from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $book = $this->booksRepository->find($id);

        if (empty($book)) {
            Flash::error('Book not found');

            return redirect(route('books.index'));
        }

        if($book->image != null){
            unlink(public_path($book->image));
        }

        $this->booksRepository->delete($id);



        Flash::success('Books deleted successfully.');

        return redirect(route('books.index'));
    }

    public function getBooks(){
        $last_id = $_GET['id'];
        $books = Books::where('id', '>', $last_id)->paginate(5);

        $html = '';
        $count = count($books);

        if(count($books) > 0){
            $lastid = $books[$count-1]->id;
            foreach ($books as $book){
                $a = $this->authorsRepository->find($book->author_id);
                $image = $book->image == null ? 'uploads/noimage.png' : $book->image;
                $html .=
                    '<tr>
                        <td>'.$book->title.'</td>
                        <td>'.$book->description.'</td>
                        <td><img src="'.$image.'"  width="100" height="100" /></td>
                        <td>'.$a->name.'</td>
                        <td width="120">
                            <form method="POST" action="http://testapp/books/'.$book->id.'" accept-charset="UTF-8">
                                <input name="_method" type="hidden" value="DELETE">
                                <input name="_token" type="hidden" value="RhMXB3EAOT4WCsvgirf8lriCW80vdJgmE7Nv5LhT">
                                <div class="btn-group">
                                    <a href="http://testapp/books/'.$book->id.'" class="btn btn-default btn-xs">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm("Are you sure?")"><i class="far fa-trash-alt"></i></button>
                                </div>
                            </form>
                        </td>
                    </tr>';

            }
        }
        $msg = array(
            'last_id' => $lastid,
            'html' => $html,
        );
        return json_encode($msg);
    }
}
