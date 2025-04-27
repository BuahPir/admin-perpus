<div>
    <form action="{{ route('upload.book') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="book_file">Upload Book File:</label>
            <input type="file" id="book_file" name="book_file" required>
        </div>
        <div>
            <label for="cover_image">Upload Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image" required>
        </div>
        <div>
            <button type="submit">Upload</button>
        </div>
    </form>
</div>
