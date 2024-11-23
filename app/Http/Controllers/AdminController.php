<?php
namespace App\Http\Controllers;

use App\Models\Book;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure the user is an admin
        $this->middleware('role:admin'); 
    }

    public function index()
    {
        // Fetch pending books with pagination (10 books per page)
        $pendingBooks = Book::where('approval_status', 'pending')->paginate(10); // Paginate with 10 books per page
        return view('admin.index', compact('pendingBooks'));
    }

    public function approve($id)
    {
        $book = Book::findOrFail($id);
        $book->approval_status = 'approved'; // Change status to approved
        $book->save();

        return redirect()->route('admin.index')->with('success', 'Book approved.');
    }

    public function reject($id)
    {
        $book = Book::findOrFail($id);
        $book->approval_status = 'rejected'; // Change status to rejected
        $book->save();

        return redirect()->route('admin.index')->with('error', 'Book rejected.');
    }
}
