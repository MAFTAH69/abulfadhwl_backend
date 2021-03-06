@extends('layouts.app')
@section('sidebar')
    <div class="col-md-2">
        @include('components.left_nav')
    </div>
@endsection

@section('content')
    <div class="col-md-10 py-3">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-success" role="alert">
                    {{ session('errors') }}
                </div>
            @endif

            <!-- ACTIONS -->
            <section id="actions" class="py-2 mb-4 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addLinkModal">
                                <i class="fas fa-plus"></i> Add Link
                            </a>

                        </div>
                    </div>
                </div>
            </section>

            <section id="links">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>LINKS</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Url</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($links as $index => $link)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><img src="http://192.168.43.114:8000/api/link/icon/{{$link->id}}" alt="Link icon" style="width: 30px;height:30px"></td>
                                        <td>{{ $link->title }}</td>
                                        <td>{{ $link->url }}</td>


                                        <td>
                                        <a href="#" role="alert" class="btn btn-outline-primary" data-toggle="modal" data-target="#editLinkModal-{{$link->id}}" data-title="{{$link->title}}" data-url="{{$link->url}} ">
                                                <i class="fas fa-info-circle">
                                                    Edit</i>
                                        </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_link', $link->id) }}"
                                                onclick="return confirm('This link will be deleted')"
                                                class="btn btn-outline-danger">
                                                <i class="fas fa-trash"> Delete</i>
                                            </a>

                                            <!-- EDIT LINK MODAL -->
        <div class="modal fade" id="editLinkModal-{{$link->id}}" tabIndex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Link</h5>
                        <button class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form method="PUT" action="{{route('edit_link',$link->id)}}">
                            @csrf

                            <div class="form-group row">
                                <label for="title"
                                class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                            <div class="col-md-6">
                                                <input id="title" type="text"
                                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                                    value="{{ old('title',$link->title) }}" required autocomplete="title" autofocus>
                                                    @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="url"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Url') }}</label>
                                            <div class="col-md-6">
                                                <input id="url" type="text"
                                                class="form-control @error('year') is-invalid @enderror" name="url"
                                                value="{{ old('url',$link->url) }}" required autocomplete="url" >
                                                @error('url')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>


            <!-- MODALS -->
            <!-- ADD LINK MODAL -->
            <div class="modal fade" id="addLinkModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Link</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_link') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="title"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                    <div class="col-md-6">
                                        <input id="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror" name="title"
                                            value="{{ old('title') }}" required autocomplete="title" autofocus>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="url"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Url') }}</label>
                                    <div class="col-md-6">
                                        <input id="url" type="text"
                                            class="form-control @error('year') is-invalid @enderror" name="url"
                                            value="{{ old('url') }}" required autocomplete="url" >
                                        @error('url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="icon"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Icon') }}</label>
                                    <div class="col-md-6">
                                        <input id="icon" type="file"
                                        class="form-control @error('icon') is-invalid @enderror" name="icon"
                                        value="{{ old('icon') }}" required autocomplete="icon" >
                                        @error('icon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!--FOOTER  -->
            <footer id="main-footer" class="bg-light text-dark mb-3">
                <div class="container">
                    <div class="col">
                        <hr>
                        <p class="lead text-center">
                            Copyright &copy; <span id="year"></span> ABUL FADHWL
                        </p>
                    </div>
                </div>
            </footer>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                crossorigin="anonymous" />

            <script>
                // Get the current year for the copyright
                $('#year').text(new Date().getFullYear());

                $('#editLinkModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var linkId = button.data('id') // Extract info from data-* attributes
  var linkTitle = button.data('title') // Extract info from data-* attributes
  var linkUrl = button.data('url') // Extract info from data-* attributes

  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
                        </script>
        </div>
    </div>
@endsection
