<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <h3>{{ $sub_title }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <td>{{ $item->id }}
                <td>{{ $item->name }}
                <td>{{ $item->email }}
            @endforeach
        </tbody>
    </table>
</body>
</html>
