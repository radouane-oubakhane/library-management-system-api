<div>
    <h1>Créer une catégorie</h1>
    <form action="/book-categories" method="post">
        @csrf
        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" id="name">
        </div>

        <div>
            <button type="submit">Créer</button>
        </div>
    </form>
</div>
