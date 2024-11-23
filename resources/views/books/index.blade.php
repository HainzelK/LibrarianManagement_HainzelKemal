<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books List - Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Books List</h3>
                    <h5 class="text-center"><a href="#">Library</a></h5>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('books.create') }}" class="btn btn-md btn-success mb-3">ADD NEW BOOK</a>
                        @if(session('success'))
                            <script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: "{{ session('success') }}",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            </script>
                        @elseif(session('error'))
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "{{ session('error') }}",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            </script>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Access Status</th>
                                    <th scope="col" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->category }}</td>
                                        <td>{{ $book->publication_date }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($book->is_accessible == 'requested') badge-warning
                                                @elseif($book->is_accessible == 'granted') badge-success
                                                @elseif($book->is_accessible == 'denied') badge-danger
                                                @endif">
                                                {{ ucfirst($book->is_accessible) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('books.destroy', $book->id) }}" method="POST">
                                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        No books available.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Custom delete confirmation
        function confirmDelete() {
            event.preventDefault(); // Prevents the form from submitting immediately
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit(); // Submit the form if confirmed
                }
            });
        }
    </script>
</body>
</html>
