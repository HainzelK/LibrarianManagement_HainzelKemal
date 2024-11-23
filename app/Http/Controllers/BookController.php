<?php

namespace App\Http\Controllers;

use App\Models\Book; // Import the Book model
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        // Get all books with pagination
        $books = Book::latest()->paginate(10);

        // Render view with books
        return view('books.index', compact('books'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

        // Create a new book
        Book::create([
            'title'        => $request->title,
            'author'       => $request->author,
            'category'     => $request->category,
            'is_physical'  => $request->is_physical,
            'available'    => $request->available,
        ]);

        // Redirect to index with success message
        return redirect()->route('books.index')->with(['success' => 'Book Successfully Created!']);
    }

    /**
     * show
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        // Get book by ID
        $book = Book::findOrFail($id);

        // Render view with book details
        return view('books.show', compact('book'));
    }

    /**
     * edit
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Get book by ID
        $book = Book::findOrFail($id);

        // Render view with book details
        return view('books.edit', compact('book'));
    }

    /**
     * update
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validate form
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

        // Get book by ID
        $book = Book::findOrFail($id);

        // Update book details
        $book->update([
            'title'        => $request->title,
            'author'       => $request->author,
            'category'     => $request->category,
            'is_physical'  => $request->is_physical,
            'available'    => $request->available,
        ]);

        // Redirect to index with success message
        return redirect()->route('books.index')->with(['success' => 'Book Successfully Updated!']);
    }

    /**
     * destroy
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        // Get book by ID
        $book = Book::findOrFail($id);

        // Delete the book
        $book->delete();

        // Redirect to index with success message
        return redirect()->route('books.index')->with(['success' => 'Book Successfully Deleted!']);
    }
}
