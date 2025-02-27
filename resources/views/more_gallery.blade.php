@extends('layouts.app')

@section('content')
    <div class="main_wrapper">
        <div class="intro_header">

            <div class="main_content">
                <div class="container">
                    <div class="row">
                        <div class="grid_section explore_iceland text-center">
                            <h2>
                                <span> Iceland Photo Gallery</span>
                            </h2>
                            <p>Fantastic Images from Iceland to Inspire Your Next Trip</p>

                            <div class="grid_content row">
                                @if(!empty($places))
                                    @foreach($places as $obj)
                                        <div class="col-md-4 col-sm-6 wow fadeIn" data-wow-duration="1s" data-wow-delay="1s">
                                            <a href="javascript:void(0);" class="photoCustomModal" title="{{$obj->place_name}}" description="{{$obj->description}}"
                                               image="{{url('uploads/'.@$obj->photo)}}">
                                                <div class="d-flex justify-content-center img_wrapper">

                                                    @if(!empty($obj->photo) && file_exists(public_path('uploads/'.$obj->photo)))
                                                        <img src="{{url('uploads/'.@$obj->photo)}}" alt="{{@$obj->place_name}}">
                                                    @else
                                                        <img src="{{url('/images/no-image.png')}}" class="img-responsive" alt="image">
                                                    @endif
                                                    <div class="hover_txt">
                                                        <h4>{{$obj->place_name}}</h4>
                                                        <p> {{str_limit(strip_tags(trim($obj->description)),180,'....')}}
                                                        </p>
                                                    </div>
                                                </div>

                                            </a>
                                        </div>
                                    @endforeach
                                @endif


                            </div>
                            <style>
                                .itspagination{
                                    position: relative;
                                    bottom: 30px;
                                }
                                @media only screen and(max-width: 320px){
                                    .itspagination{
                                        position: relative;
                                        left: -27px;
                                    }
                                }
                            </style>
                            <div class="col-12 mt-4 float-left paginateDivMain itspagination">
                                <nav aria-label="page navigation example">

                                    {{ $places->links() }}
                                </nav>
                            </div>
                            {{--<div class="row">--}}
                            {{--<a href="#" class="hvr-float-shadow view_all">View more</a>--}}
                            {{--</div>--}}

                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
    <div class="modal fade gallery_modal" id="gallery_modal">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="" style="padding: 24px;height: 590px;overflow-y: scroll;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{ url('images/plus.png') }}" alt="Plus btton"></button>
                <h3 id="title"> </h3>
                <div class="main_wrapper">
                    <div class="form-group">

                        <img id="image" src="" alt="">

                    </div>
                    <div class="form-group">
                        <p id="description"></p>
                    </div>


                </div>

            </div>
        </div>
    </div>
    <script>
        $(Document).ready(function () {
            $('.photoCustomModal').click(function () {
                var title=$(this).attr('title');
                var description=$(this).attr('description');
                var image=$(this).attr('image');
                $('#title').html(title);
                $('#description').html(description);
                $('#image').attr('src',image);
                $('#gallery_modal').modal('show');
            })
        })
    </script>
@endsection
