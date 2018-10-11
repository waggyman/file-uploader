<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>File Uploader</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://icono-49d6.kxcdn.com/icono.min.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="content">
            {{-- Button --}}
            <div>
                <button class='btn btn-lg bordered' data-toggle="modal" style='background-color:transparent;' data-target="#exampleModal">
                    <i class="fa fa-upload"></i>
                </button>
                {{-- search --}}
                <div class="form-group has-search pull-right">
                        <span class="fa fa-search form-control-feedback"></span>
                <input data-url="{{url('/')}}" id="search-doc" type="text" class="form-control search" placeholder="Search">
                </div>

                <div class="dropdown show pull-right">
                <a href="#" class='btn btn-lg bordered pull-right dropdown-toggle' style='background-color:transparent;margin-right:10px;border:none' role="button" id="sorted-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sort-amount-desc "></i>
                </a>
                {{-- sort dropdown --}}
                 <div class="dropdown-menu" aria-labelledby="sorted-menu">
                    <a class="dropdown-item" href="/?sort_by=type&order_by=asc">Type</a>
                    <a class="dropdown-item" href="/?sort_by=name&order_by=asc">Name</a>
                    <a class="dropdown-item" href="/?sort_by=name&order_by=asc">A/Z</a>
                    <a class="dropdown-item" href='/?sort_by=name&order_by=desc'>Z/A</a>
                </div>
                </div>

                <div class="dropdown show pull-right">                
                <button class='btn btn-lg round-bordered pull-right' style='background-color:transparent;margin-right: 10px;' role="button" id="view-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if($view == 'thumbnails')    
                    <i class="fa fa-th-large"></i>
                    @else
                    <i class="fa fa-th-list"></i>                    
                    @endif
                </button>
                <div class="dropdown-menu" aria-labelledby="view-menu">
                    <a class="dropdown-item" href="/?sort_by={{$sort_by}}&order_by={{$order_by}}&view=thumbnails">
                        <i class="fa fa-th-large"></i> thumbnails
                    </a>
                    <a class="dropdown-item" href="/?sort_by={{$sort_by}}&order_by={{$order_by}}&view=list">
                        <i class="fa fa-th-list"></i> List
                    </a>
                </div>
                </div>
            </div>
           
            

            @if($view == 'thumbnails')
            <div>
                @foreach(array_chunk($files, 4) as $chunkedFiles)
                    <div class="row">
                        @foreach($chunkedFiles as $file)                               
                        <div class="col-3">
                            <div class="thumbnail clearfix">
                                @if(in_array($file->type, $images))
                                <div class="pull-left" style="width: 72px; height: 72px; text-align: center; padding-right: 15px">
                                    <img src="{{ asset('uploads/' . $file->type . '/' . $file->unique_name) }}" alt="" style="width:100%; display: block; margin-left:auto; margin-right: auto; padding: 0">
                                </div>
                                @else
                                <img src="{{array_key_exists($file->type, $file_icons) ? $file_icons[$file->type] : 'http://placehold.it/72x72/'}}" class="pull-left" style="width: 72px; height: 72px;">
                                @endif
                                <div class="caption" class="pull-right">
                                    <p class="file-title" role="button" id="view-menu-{{$file->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$file->name}}</p>
                                    <div class="dropdown-menu" aria-labelledby="view-menu-{{$file->id}}">
                                            <button type="button" class="btn " style='background-color:transparent;'>
                                                <i class="fa fa-print"></i>
                                            </button>
                                            <a class="btn" style='background-color:transparent;color:black' href="{{ asset('uploads/' . $file->type . '/' . $file->unique_name) }}" download><i class="fa fa-download"></i></a>
                                            <button type="button" class="btn " style='background-color:transparent;'>
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            <button type="button" class="btn " style='background-color:transparent;'>
                                                <i class="fa fa-share-alt"></i>
                                            </button>
                                    </div>
                                    <p class="file-type">{{$file->type}}</p>
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                @endforeach
            </div>
            @elseif($view == 'list')
            <ul class="list-group" style="padding-top: 25px;">
                @foreach($files as $file)
                <li class="list-group-item">
                    <div class="thumbnail clearfix">
                        @if(in_array($file->type, $images))
                        <div class="pull-left" style="width: 72px; height: 72px; text-align: center; margin-right: 15px">
                            <img src="{{ asset('uploads/' . $file->type . '/' . $file->unique_name) }}" alt="" style="width:100%; display: block; margin-left:auto; margin-right: auto; padding: 0">
                        </div>
                        @else
                        <img src="{{array_key_exists($file->type, $file_icons) ? $file_icons[$file->type] : 'http://placehold.it/72x72/'}}" class="pull-left" style="width: 72px; height: 72px;">
                        @endif
                        <div class="caption" class="pull-right">
                            <p class="file-title" role="button" id="view-menu-{{$file->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$file->name}}</p>
                            
                            <p class="file-type">{{$file->type}}</p>
                            <div aria-labelledby="view-menu-{{$file->id}}">
                                    <button type="button" class="btn " style='background-color:transparent;'>
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <a class="btn" style='background-color:transparent;color:black' href="{{ asset('uploads/' . $file->type . '/' . $file->unique_name) }}" download><i class="fa fa-download"></i></a>
                                    <button type="button" class="btn " style='background-color:transparent;'>
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    <button type="button" class="btn " style='background-color:transparent;'>
                                        <i class="fa fa-share-alt"></i>
                                    </button>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/upload" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" id="">
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#myInput').trigger('focus')
            })

            $('#search-doc').keypress(function(e){
                if(e.which == 13){//Enter key pressed
                    var value = $(this).val()
                    window.location.replace($(this).data('url') + '?search=' + value)
                }
            });

        </script>
    </body>
</html>
