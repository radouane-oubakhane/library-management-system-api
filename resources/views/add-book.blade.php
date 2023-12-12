<div>
    <h1>Ajouter un livre</h1>
    <form action="/books" method="post">
        @csrf
        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title">
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
            <label for="publication_year">Année de publication</label>
            <input type="number" name="publication_year" id="publication_year">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="cover_image">Image de couverture</label>
            <input type="text" name="cover_image" id="cover_image">
        </div>
        <div>
            <label for="number_of_pages">Nombre de pages</label>
            <input type="number" name="number_of_pages" id="number_of_pages">
        </div>
        <div>
            <label for="language">Langue</label>
            <input type="text" name="language" id="language">
        </div>
        <div>
            <label for="publisher">Éditeur</label>
            <input type="text" name="publisher" id="publisher">
        </div>
        <div>
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn">
        </div>
        <div>
            <label for="price">Prix</label>
            <input type="number" name="price" id="price">
        </div>
        <div>
            <label for="stock">Stock</label>
            <input type="number" name="stock" id>
        </div>

        <button type="submit">Ajouter</button>


</div>
