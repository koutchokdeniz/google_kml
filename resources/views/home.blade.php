<!-- resources/views/home.blade.php -->


    @include('partials._logout')
    <form action="{{ route('upload-kml') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="kml_file" accept=".kml">
        <button type="submit">Upload KML</button>

    </form>
   