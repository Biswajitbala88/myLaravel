<html>
<head>
    <title>File Upload</title>


    <body>
        @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
        <div>
            File Name: {{ session('file') }}
        </div>
        @endif

        {{ $title }} <br>
        Created At: {{ $created_at }} <br><br>
        <form action="/upload" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <button type="submit">Upload</button>   
        </form>
    </body>
</html>