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
    @foreach ($member as $m  )
        <div class="row">
        <div class="col-sm-3">
            <p class="mb-0">Full Name</p>
        </div>
        <div class="col-sm-9">
            <p class="text-muted mb-0">{{$m->first_name}} {{$m->last_name}} </p>
        </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <p class="mb-0">Email</p>
    </div>
    <div class="col-sm-9">
        <p class="text-muted mb-0">{{$m->email}} </p>
    </div>
</div>
<div class="row">
   <div class="col-sm-3">
            <p class="mb-0">Phone</p>
        </div>
        <div class="col-sm-9">
            <p class="text-muted mb-0">{{$m->phone}}</p>
        </div>
</div>
<a class="btn btn-primary" href="/members/{{$m->id}}/edit">Edit</a>
<hr>


    <h3> les livres emprunter</h3>

    <hr>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">date d'emprunte</th>
            <th scope="col">l'etat d'emprunte</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($m->bookCopy as $book)
        <tr>
            <td>{{$book->title }}</td>
            <td>{{$book->borrow_date}}</td>
            <td>{{$book->status}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    @endforeach
</div>
</body>
</html>
