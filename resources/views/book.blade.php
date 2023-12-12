<div>
<h1>Livre</h1>
<div>
    <h2>{{ $book->title }}</h2>
    <div>
        <p>{{ $book->description }}</p>
    </div>
    <div>
        <p>Année de publication: {{ $book->publication_year }}</p>
    </div>
    <div>
        <p>Nombre de pages: {{ $book->number_of_pages }}</p>
    </div>
    <div>
        <p>Langue: {{ $book->language }}</p>
    </div>
    <div>
        <p>Éditeur: {{ $book->publisher }}</p>
    </div>
    <div>
        <p>ISBN: {{ $book->isbn }}</p>
    </div>
    <div>
        <p>Prix: {{ $book->price }}</p>
    </div>
    <div>
        <p>Auteur: {{ $book->author->first_name }} {{ $book->author->last_name }}</p>
    </div>
    <div>
        <p>Catégorie: {{ $book->bookCategory->name }}</p>
    </div>
</div>
