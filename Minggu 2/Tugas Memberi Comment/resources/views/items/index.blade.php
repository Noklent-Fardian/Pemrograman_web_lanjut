<!DOCTYPE html>
<html>
{{-- Commitan setelah dipindahkan --}}
<head>
    <title>Item List</title>
</head>

<body>
    <h1>Items</h1>

    <!-- menampilkan pesan jka kondisi terpenusi-->
    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <!-- link untuk menambahkan item baru -->
    <a href="{{ route('items.create') }}">Add Item</a>

    <!-- memunculkan daftar item -->
    <ul>
        @foreach ($items as $item)
        <li>
            <!-- menampilkan nama item -->
            {{ $item->name }} -

            <!-- link untuk mengedit  -->
            <a href="{{ route('items.edit', $item) }}">Edit</a>

            <!-- form untuk menghapus  -->
            <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                <!-- token csrf untuk mengamankan form -->
                @csrf

                <!-- menggunakan method DELETE untuk menghapus item -->
                @method('DELETE')

                <!-- tombol untuk menghapus item -->
                <button type="submit">Delete</button>
            </form>
        </li>
        @endforeach
    </ul>
</body>

</html>