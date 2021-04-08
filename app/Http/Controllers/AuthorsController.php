<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorsRequest;
use App\Http\Requests\UpdateAuthorsRequest;
use App\Repositories\AuthorsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AuthorsController extends AppBaseController
{
    /** @var  AuthorsRepository */
    private $authorsRepository;

    public function __construct(AuthorsRepository $authorsRepo)
    {
        $this->authorsRepository = $authorsRepo;
    }

    /**
     * Display a listing of the Authors.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $authors = $this->authorsRepository->all();

        return view('authors.index')
            ->with('authors', $authors);
    }

    /**
     * Show the form for creating a new Authors.
     *
     * @return Response
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created Authors in storage.
     *
     * @param CreateAuthorsRequest $request
     *
     * @return Response
     */
    public function store(CreateAuthorsRequest $request)
    {
        $input = $request->all();

        $authors = $this->authorsRepository->create($input);

        Flash::success('Authors saved successfully.');

        return redirect(route('authors.index'));
    }

    /**
     * Display the specified Authors.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $authors = $this->authorsRepository->find($id);

        if (empty($authors)) {
            Flash::error('Authors not found');

            return redirect(route('authors.index'));
        }

        return view('authors.show')->with('authors', $authors);
    }

    /**
     * Show the form for editing the specified Authors.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $authors = $this->authorsRepository->find($id);

        if (empty($authors)) {
            Flash::error('Authors not found');

            return redirect(route('authors.index'));
        }

        return view('authors.edit')->with('authors', $authors);
    }

    /**
     * Update the specified Authors in storage.
     *
     * @param int $id
     * @param UpdateAuthorsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuthorsRequest $request)
    {
        $authors = $this->authorsRepository->find($id);

        if (empty($authors)) {
            Flash::error('Authors not found');

            return redirect(route('authors.index'));
        }

        $authors = $this->authorsRepository->update($request->all(), $id);

        Flash::success('Authors updated successfully.');

        return redirect(route('authors.index'));
    }

    /**
     * Remove the specified Authors from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $authors = $this->authorsRepository->find($id);

        if (empty($authors)) {
            Flash::error('Authors not found');

            return redirect(route('authors.index'));
        }

        $this->authorsRepository->delete($id);

        Flash::success('Authors deleted successfully.');

        return redirect(route('authors.index'));
    }
}
