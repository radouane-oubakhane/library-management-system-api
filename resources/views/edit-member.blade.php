<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <!-- Styles -->

</head>
<body class="antialiased">

@include('nav-bar')
<div class="container">

    <h1>Edit Profile</h1>
    <form action="/members/{{ $member->id }}/edit" method="POST">
        @csrf
        <div>
            <label for="name">First Name</label>
            <input type="text" name="first_name" value="{{ $member->first_name }}">
        </div>
        <div>
            <label for="name">Last Name</label>
            <input type="text" name="last_name" value="{{ $member->last_name }}">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" value="{{ $member->email }}">
        </div>
        <div>
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{ $member->phone }}">
        </div>
        <div>
            <label for="address">Address</label>
            <input type="text" name="address" value="{{ $member->address }}">
        </div>
        <div>
            <label for="password">Password</label>
            <label>
                <input type="text" name="password" value="{{ $member->password }}">
            </label>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <label>
                <input type="text" name="password_confirmation" value="{{ $member->password_confirmation }}">
            </label>
        </div>
        <div>
            <button type="submit">Update</button>
        </div>
    </form>
</div>

</body>
</html>
