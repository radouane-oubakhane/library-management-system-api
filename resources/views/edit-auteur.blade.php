<!-- resources/views/authors/create.blade.php -->




<div class="container">
        <h2>Edit Author</h2>
        <form action="/authors/{{ $author->id }}/edit"  method="post">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $author->first_name }}">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $author->last_name }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $author->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $author->phone }}" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" class="form-control" rows="3"  required>{{$author->address}}</textarea>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $author->date_of_birth }}" required>
            </div>
            <button type="submit" class="btn btn-primary" >Update</button>
        </form>
    </div>

