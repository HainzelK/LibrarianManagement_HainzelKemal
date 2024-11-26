<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    /**
     * Apply middleware based on usertype (admin/librarian).
     */


    /**
     * index
     *
     * @return View
     */
    public function index_librarian()
    {
        if (auth()->user()->usertype === 'librarian') {
            $books = Book::where('status', 'approved')->latest()->paginate(10);
        } elseif (auth()->user()->usertype === 'admin') {
            $books = Book::latest()->paginate(10);
        } else {
            return redirect()->route('unauthorized');
        }
    
        // Ensure the variable is passed to the view
        return view('librarian.dashboard', compact('books'));
    }
    

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('librarian.create_book');
    }

    /**
     * store
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

        // Create a book with status pending
        Book::create([
            'title'        => $request->title,
            'author'       => $request->author,
            'category'     => $request->category,
            'is_physical'  => $request->is_physical,
            'available'    => $request->available,
            'status'       => 'pending', // Default status
        ]);

        return redirect()->route('librarian.dashboard')->with(['success' => 'Book Successfully Created and Pending Approval!']);
    }

    /**
     * edit
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $book = Book::findOrFail($id);

        // Only allow editing if the book is pending
        if ($book->status !== 'pending') {
            abort(403, 'You can only edit pending books.');
        }

        return view('librarian.edit', compact('book'));
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
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

        $book = Book::findOrFail($id);

        // Update book details and reset to pending status
        $book->update([
            'title'        => $request->title,
            'author'       => $request->author,
            'category'     => $request->category,
            'is_physical'  => $request->is_physical,
            'available'    => $request->available,
            'status'       => 'pending', // Reset status to pending
        ]);

        return redirect()->route('librarian.dashboard')->with(['success' => 'Book Updated and Pending Approval!']);
    }

    /**
     * destroy
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        // Only allow deleting pending books
        if ($book->status !== 'pending') {
            abort(403, 'You can only delete pending books.');
        }

        $book->delete();

        return redirect()->route('librarian.dashboard')->with(['success' => 'Book Successfully Deleted!']);
    }

    /**
     * approve
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function approve(string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        // Approve the book
        $book->update(['status' => 'approved']);

        return redirect()->route('admin.dashboard')->with(['success' => 'Book Approved!']);
    }

    /**
     * reject
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function reject(string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        // Reject the book
        $book->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard')->with(['success' => 'Book Rejected!']);
    }
}
