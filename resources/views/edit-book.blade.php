<div>
    <h1>Modifier un livre</h1>
    <form action="{{ route('books.update', $book->id) }}" method="post">
        @csrf
        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="{{ $book->title }}">
        </div>
        <div>
            <label for="author_id">Auteur</label>
            <select name="author_id" id="author_id">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">
                        {{ $author->first_name }}  {{ $author->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="book_category_id">Catégorie</label>
            <select name="book_category_id" id="book_category_id">
                @foreach($bookCategories as $bookCategory)
                    <option value="{{ $bookCategory->id }}">
                        {{ $bookCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="{{ $book->isbn }}">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description">{{ $book->description }}</textarea>
        </div>
        <div>
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ $book->stock }}">
        </div>
        <div>
            <label for="pubisher">Editeur</label>
            <input type="text" name="publisher" id="publisher" value="{{ $book->publisher }}">
        </div>
        <div>
            <label for="published_at">Date de publication</label>
            <input type="date" name="published_at" id="published_at" value="{{ $book->published_at }}">
        </div>
        <div>
            <label for="language">Langue</label>
            <input type="text" name="language" id="language" value="{{ $book->language }}">
        </div>
        <div>
            <label for="edition">Edition</label>
            <input type="text" name="edition" id="edition" value="{{ $book->edition }}">
        </div>



        <button type="submit">Modifier</button>


</div>

