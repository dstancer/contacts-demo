@extends('layout')

@section('title', $title . ' Contact')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@stop

@section('content')


    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
        @if($errors->any())
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </div>
        @endif
        </div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2>{{ $title }} Contact {{ $contact['name'] .' '.$contact['surname'] }}</h2>
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $contact['name'] }}" placeholder="First Name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="surname" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ $contact['surname'] }}" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">e-mail</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" value="{{ $contact['email'] }}" placeholder="e-mail" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        @if($contact['photo'] !== '')
                            <img src="/photos/{{ $contact['photo'] }}">
                        @else
                            <img src="/photos/placeholder.png">
                        @endif
                        {{--<div>
                            <input type="file" id="photo" name="photo" value="Change your photo">
                        </div>--}}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo">
                            <label class="custom-file-label" for="photo">Change your photo</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="favorite" class="col-sm-2 col-form-label">Favorite</label>
                    <div class="col-sm-10 text-sm-left">
                        <input type="checkbox" class="form-check-input" data-toggle="toggle" id="favorite" name="favorite" value="favorite"
                               @if($contact['favorite'])
                               checked="checked"
                               @endif
                        >
                    </div>
                </div>
                @if($contact['id'] > 0)
                <div class="form-group row">
                    <label for="numbers" class="col-sm-2 col-form-label">Phone Numbers</label>
                    <div class="col-sm-10">
                        <a class="btn btn-success" href="#"
                           data-toggle="modal"
                           data-method="create"
                           data-target="#phoneModal"
                           data-id=""
                           data-contactid="{{ $contact['id'] }}"
                           data-key="{{ config('app.key') }}"
                        >
                            <i class="fas fa-plus-square fa-sm"></i> New Phone Number
                        </a>
                        <table class="display responsive nowrap" id="numbers" width="100%">
                            <thead class="thead-light">
                            <th>Edit</th>
                            <th>Label</th>
                            <th>Number</th>
                            <th>Delete</th>
                            </thead>
                            <tbody>
                            @foreach($contact['phones'] as $phone)
                                <tr>
                                    <td class="dt-body-center">
                                        <a class="btn btn-primary" href="#"
                                           data-toggle="modal"
                                           data-method="update"
                                           data-target="#phoneModal"
                                           data-label="{{ $phone['label'] }}"
                                           data-number="{{ $phone['number'] }}"
                                           data-id="{{ $phone['id'] }}"
                                           data-contactid="{{ $contact['id'] }}"
                                           data-key="{{ config('app.key') }}"
                                           role="button"
                                        >
                                            <i class="fas fa-pencil-alt fa-sm"></i>
                                        </a>
                                    </td>
                                    <td>{{ $phone['label'] }}</td>
                                    <td>{{ $phone['number'] }}</td>
                                    <td class="dt-body-center">
                                        <a class="btn btn-danger" href="#"
                                           data-toggle="modal"
                                           data-method="destroy"
                                           data-target="#phoneModalDestroy"
                                           data-label="{{ $phone['label'] }}"
                                           data-number="{{ $phone['number'] }}"
                                           data-id="{{ $phone['id'] }}"
                                           data-contactid="{{ $contact['id'] }}"
                                           data-key="{{ config('app.key') }}"
                                           role="button"
                                        >
                                            <i class="fas fa-trash-alt fa-sm"></i>
                                        </a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Phone Label</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="label" name="label" value="" placeholder="Label" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="number" name="number" value="" placeholder="Number"required>
                        </div>
                    </div>

                @endif
                <button type="submit" class="btn btn-success" id="submit">Submit</button>
                <a class="btn btn-warning" href="{{ url(config('app.url')) }}" role="button">Cancel</a>
            </form>

            @include('edit._phone_edit')
            @include('edit._phone_destroy')
            @include('edit._success')

        </div>
    </div>

@stop

@section('script')
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    @include('edit._edit_js')
@stop