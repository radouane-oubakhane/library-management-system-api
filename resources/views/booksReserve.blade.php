<div>
    <h1>Liste des livres</h1>

    <ul>
        @foreach ($books as $book)
            <li>
                {{ $book->title }} -
                numbers Copies  : {{ $book->borrowedCopies }} /
                numbers Copies empruntées {{ $book->borrowedCopiesReserve }}
                Réservations : {{ $book->reservationsCount }}
            </li>
        @endforeach
    </ul>
</div>
