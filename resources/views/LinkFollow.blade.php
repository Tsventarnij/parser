@extends('template')

@section('content')
    <form method="POST" action="/link-follow">
        @csrf
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Domain:</label>
            <div class="col-sm-10">
                <input type="text" name="domain" class="form-control" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">List of links:</label>
            <div class="col-sm-10">
                <textarea name="links" class="form-control" required></textarea>
            </div>
        </div>
        <input type="submit" value="Parse" class="btn btn-primary">
    </form>
    @if(isset($result))
        <table class="table table-hover">
            <thead><tr>
                <th scope="col">Link</th>
                <th scope="col">Domain name</th>
                <th scope="col">Link exist</th>d
                <th scope="col">Link is dofollow</th>
            </tr></thead>
            <tbody>
        @foreach ($result as $row)
            <tr>
                <td>{{ $row['link'] }}</td>
                <td>{{ $row['domain'] }}</td>
                <td>{{ $row['exist'] ? "Yes" : "No" }}</td>
                <td>{{ $row['dofollow'] ? "Yes" : "No" }}</td>
            </tr>
        @endforeach
            </tbody>
        </table>
    @endif

@endsection