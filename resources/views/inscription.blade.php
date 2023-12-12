<div>
    <h1>S'inscrire</h1>
    <form action="/inscriptions" method="post">
        @csrf
        <div>
            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" id="first_name">
        </div>

        <div>
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" id="last_name">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>

        <div>
            <label for="phone">Téléphone</label>
            <input type="text" name="phone" id="phone">
        </div>

        <div>
            <label for="address">Adresse</label>
            <input type="text" name="address" id="address">
        </div>

        <div>
            <label for="date_of_birth">Date de naissance</label>
            <input type="date" name="date_of_birth" id="date_of_birth">
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <div>
            <button type="submit">S'inscrire</button>
        </div>
    </form>

</div>
