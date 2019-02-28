@extends('layout')

@section('title', 'Contacts - Favorites')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@stop

@section('content')


        <h2>Favorites</h2>
        <table class="display" id="favorites" width="100%">
            <thead class="thead-light">
            <th>Name</th>
            <th>Surname</th>
            <th>e-mail</th>
            <th>Image</th>
            <th>Numbers</th>
            </thead>
            <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact['name'] }}</td>
                    <td>{{ $contact['surname'] }}</td>
                    <td>{{ $contact['email'] }}</td>
                    <td class="dt-body-center"><img src="/photos/{{ $contact['photo'] }}" height="40"></td>
                    <td>
                        <ul>
                            @foreach($contact['phones'] as $number)
                                <li class="small">{{ $number['label'] }}: {{ $number['number'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


@stop

@section('script')
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            var dataTables = $('#favorites').DataTable({
                "order": [[ 1, "asc" ]],
                "columns": [
                    null,
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false}
                ]
            });
        });
    </script>
@stop