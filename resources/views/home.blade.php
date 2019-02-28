@extends('layout')

@section('title', 'Contacts')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@stop

@section('content')

    <h2>Contacts</h2>

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
            <div class="col-10">
                <a class="btn btn-success" href="/contact/create" role="button" id="newBtn">
                    <i class="fas fa-plus-square"></i>
                    New Contact
                </a>
            </div>

            <div class="col-2 justify-content-end">
            <div class="btn-group pull-right">
                <button id="favoritesBtn" class="btn btn-outline-secondary filter">Favorites</button>
                <button id="allBtn" class="btn btn-secondary filter">All</button>
            </div>
            </div>
        </div>

        <table class="display responsive nowrap" id="contacts" width="100%">
            <thead class="thead-light">
            <tr>
                <th>Edit</th>
                <th>Favorite</th>
                <th>Name</th>
                <th>Surname</th>
                <th>e-mail</th>
                <th>Image</th>
                <th>Numbers</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td class="dt-body-center">
                        <a class="btn btn-primary" href="/contact/{{ $contact['id'] }}/edit" role="button"><i class="fas fa-pencil-alt fa-sm"></i></a>
                    </td>
                    @if($contact['favorite'])
                        <td class="dt-body-center" data-order="true">
                            <a class="btn btn-outline-warning" href="/contact/{{ $contact['id'] }}/favToggle" role="button" title="favorite">
                                <i class="fas fa-heart fa-sm"></i>
                            </a>
                        </td>
                    @else
                        <td class="dt-body-center" data-order="false">
                            <a class="btn btn-outline-secondary" href="/contact/{{ $contact['id'] }}/favToggle" role="button"><i
                                        class="far fa-heart fa-sm"></i></a>
                        </td>
                    @endif

                    <td>{{ $contact['name'] }}</td>
                    <td>{{ $contact['surname'] }}</td>
                    <td>{{ $contact['email'] }}</td>
                    <td class="dt-body-center">
                        <img src="/photos/{{ $contact['photo'] }}" height="40">
                    </td>
                    <td>
                        <ul>
                            @foreach($contact['phones'] as $number)
                                <li class="small">{{ $number['label'] }}: {{ $number['number'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="dt-body-center">
                        <a class="btn btn-danger"
                           href="#"
                           data-toggle="modal"
                           data-target="#contactModalDestroy"
                           data-method="destroy"
                           data-id="{{ $contact['id'] }}"
                           data-key="{{ config('app.key') }}"
                           role="button"><i class="fas fa-trash-alt fa-sm"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('home._contact_destroy')
@stop

@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    @include('home._home_js')
@stop