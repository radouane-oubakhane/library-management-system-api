<div>
    <h1>Edit une catégorie</h1>
    <form action="/book-categories/{{ $category->id }}/edit" method="post">
        @csrf
        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" id="name " value="{{$category->name}}">
        </div>

        <div>
            <button type="submit">Edit</button>
        </div>
    </form>
</div>
