<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>
    <h1>Add Item</h1>
    {{-- form untuk menambahkan item --}}
    <form action="{{ route('items.store') }}" method="POST"> 
        @csrf
      <!-- token csrf untuk mengamankan form -->
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <button type="submit">Add Item</button>
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> 
    <!-- tombol untuk kembali ke halaman utama -->
</body>
</html>