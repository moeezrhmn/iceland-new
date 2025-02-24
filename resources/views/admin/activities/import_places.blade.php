@extends('layouts.master')

@section('title', 'TripXonic | Import Files')


@section('styles')
        <!-- BEGIN PAGE LEVEL PLUGINS -->


{!! Html::style('assets/admin/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}
{{--progress bar start style--}}
        <!-- Generic page styles -->
<link rel="stylesheet" href="https://blueimp.github.io/jQuery-File-Upload/css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="https://blueimp.github.io/jQuery-File-Upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/jQuery-File-Upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="https://blueimp.github.io/jQuery-File-Upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="https://blueimp.github.io/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css"></noscript>



{{--progress bar end style--}}
<style>
    .form-control.required.input_address {
        width: 104%;
    }
    .btn.default.date_btn {  left: -4px;  padding: 5px;  }
    .portlet-body.form {
        margin: 0 auto;

    }
    .form-btn-download {
        margin: 0 auto;
        width: 40%;
    }
    .form-body {
        margin: 0 auto;
        width: 82%;
    }
    .upload_progress {
        margin: 0 auto;
        width: 82%;
    }

</style>
        <!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('content')
        <!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Import Places
    <small>Import a new places and add them to this site.</small>
</h3>

<!-- END PAGE TITLE-->
<!-- BEGIN PAGE BAR -->

<!-- End PAGE BAR -->
<div class="portlet light bordered">
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <div class="form-btn-download">
            <div class="title-label">
                <label > Download Logs</label>
            </div>
            <a href="{{url('admin/places/logs')}}" class="btn default"> Download Logs </a>
        </div>
        <hr>
        <form method="post" enctype="multipart/form-data" action="{{ url('admin/places/store-import') }}"
              class="horizontal-form dropzone">
            {{--            {{ method_field('POST') }}--}}
            {{ csrf_field() }}
            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> You have <?php echo count($errors->all()) ?> errors. Please check below.</span>
                    </div>
                @endif
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button>
                    Your form validation is successful!
                </div>
                <!--/row-->
                <div class="row">
                     <div class="col-md-12 ">
                        <div class="form-group">
                        <label class="control-label"> Choose Excel File  </label>
                            <p id="image_error" class="text-danger">{{$errors->first('file')}}</p>
                        <input type="file" name="file" accept="xls|csv"  class="with-preview required"  />

                        </div>
                    </div>
                    <div class=" pull-right">
                        <button type="submit" class="btn green btn_save">
                            <i class="fa fa-check"></i> Import
                        </button>
                        <a href="{{url('admin/places')}}" class="btn default"> Cancel </a>
                    </div>
                </div>
            </div>
            <hr>
    </form>

        <form method="post" id="fileupload" enctype="multipart/form-data" action="{{ url('admin/places/store-images')}}"
              class="horizontal-form dropzone">
            {{ csrf_field() }}
            <div class="upload_progress">
                <!--/row-->
                <div class="row">
                    <div class="col-md-12 ">
                            <label class="control-label"> Choose images  </label>
                            <p id="image_error" class="text-danger">{{$errors->first('file')}}</p>
                        <!-- Redirect browsers with JavaScript disabled to the origin page -->

                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                        <div class="row fileupload-buttonbar">
                            <div class="col-lg-7">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="images[]" multiple>
                </span>
                                <button type="submit" class="btn btn-primary start">
                                    <i class="glyphicon glyphicon-upload"></i>
                                    <span>Start upload</span>
                                </button>
                            {{--    <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancel upload</span>
                                </button>--}}
                                <button type="button" class="btn btn-danger delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Delete</span>
                                </button>
                                <input type="checkbox" class="toggle">
                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>
                            </div>
                            <!-- The global progress state -->
                            <div class="col-lg-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        <!-- The table listing the files available for upload/download -->
                        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                    </div>
                    <div class=" pull-right">

                        <a href="{{url('admin/places')}}" class="btn default"> <i class="fa fa-arrow-left"></i> Back </a>
                    </div>
                </div>
            </div>

        </form>

        <!-- END FORM-->


</div>

</div>
@endsection
@section('script')

    <!-- BEGIN PAGE LEVEL PLUGINS -->

            {{-- progress bar start--}}
{{--progress bar start--}}
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
     {{--  {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}--}}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script>

</script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

{!! Html::script('assets/admin/plugins/progress_bar/js/vendor/jquery.ui.widget.js') !!}
<!-- The Templates plugin is included to render the upload/download listings -->
{!! Html::script('assets/admin/plugins/progress_bar/js/tmpl.min.js') !!}
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
{!! Html::script('assets/admin/plugins/progress_bar/js/load-image.all.min.js') !!}
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
{!! Html::script('assets/admin/plugins/progress_bar/js/canvas-to-blob.min.js') !!}
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
{!! Html::script('assets/admin/plugins/progress_bar/js/bootstrap.min.js') !!}
<!-- blueimp Gallery script -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.blueimp-gallery.min.js') !!}
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.iframe-transport.js') !!}
<!-- The basic File Upload plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload.js') !!}
<!-- The File Upload processing plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload-process.js') !!}
<!-- The File Upload image preview & resize plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload-image.js') !!}
<!-- The File Upload audio preview plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload-audio.js') !!}
<!-- The File Upload video preview plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload-video.js') !!}
<!-- The File Upload validation plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload-validate.js') !!}
<!-- The File Upload user interface plugin -->

{!! Html::script('assets/admin/plugins/progress_bar/js/jquery.fileupload-ui.js') !!}
<!-- The main application script -->

{!! Html::script('assets/admin/plugins/progress_bar/js/main.js') !!}
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>

{!! Html::script('assets/admin/plugins/progress_bar/js/cors/jquery.xdr-transport.js') !!}
<![endif]-->

{{-- progress bar end--}}
            <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL script -->
            <!-- End PAGE LEVEL script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&sensor=false&amp;libraries=places">
    </script>
    {!! Html::script('assets/admin/js/jquery.geocomplete.js') !!}
    <script>

        $(function () {
            $("#geocomplete").geocomplete({
                map: ".map_canvas",
                details: "form ",
                markerOptions: {
                    draggable: true
                }
            });

            $("#geocomplete").bind("geocode:dragged", function (event, latLng) {
             $("input[name=lat]").val(latLng.lat());
                $("input[name=lng]").val(latLng.lng());
                $("#reset").show();
            });
            $("#reset").click(function () {
                $("#geocomplete").geocomplete("resetMarker");
                $("#reset").hide();
                return false;
            });

            $("#find").click(function () {
                $("#geocomplete").trigger("geocode");
            }).click();
        });

        ///////////////////////////////get single  address for update////////////////////////
        $(document).on('click', "#address_edit", function () {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('data-content');
            $.ajax
            ({
                //contentType: "application/json; charset=utf-8",
                type: "POST",
                url: admin_url + "/admin/restaurants/edit_address",
                data: {'id': id, '_token': token},
                dataType: 'json',

                success: function (data) {
                    //alert(data.latitude);
                    $("input[name='lat']").val(data.latitude);
                    $("input[name='lng']").val(data.longitude);
                    $("input[name='formatted_address']").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("input[name='country']").val(data.country);
                    $("input[name='locality']").val(data.city);
                    $("input[name='administrative_area_level_1']").val(data.state);
                    $("input[name='country']").val(data.country);
                    $("input[name='postal_code']").val(data.zipcode);
                    $("input[name='address_id']").val(data.address_id);

                }
            });

        });

    </script>




@endsection