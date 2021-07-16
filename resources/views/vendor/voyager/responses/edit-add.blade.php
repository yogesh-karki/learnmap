@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    @php
    if(request("requestid"))
    {
        $user_request = \App\Models\UserRequest::find(request("requestid"));
        if(!$user_request->seen)
           {
            $user_request->seen = "1";
            $user_request->save();
           }
    }
    @endphp
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div id="app" class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('add_response') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->


                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif



                            @if($edit)
                                @php
                                    $user_request = \App\Models\UserRequest::find($dataTypeContent->user_request_id);
                                    $dataTypeContent->response_date = \Carbon\Carbon::parse($dataTypeContent->created_at)->format('m/d/Y g:i A');
                                    // $dataTypeContent contains responses data.
                                    $responseInventories = $dataTypeContent->inventories;
                                    $modelInventories = [];
                                    foreach($responseInventories as $item){
                                        $pivot = $item['pivot'];
                                        unset($pivot['response_id']);
                                        array_push($modelInventories,$pivot);
                                    }
                                    if($user_request->individual_id)
                                    {
                                        $user = \App\Models\Individual::find($user_request->individual_id);
                                    }

                                    else
                                    {
                                        $user = \App\Models\Institution::find($user_request->institution_id);
                                    }
                                    $inventories  = \App\Models\Inventory::where(['project_id' => $user_request->project_id])->get();

                                @endphp
                            @else
                                @php
                                    $user_request = \App\Models\UserRequest::find(request("requestid"));
                                    if($user_request->individual_id)
                                    {
                                        $user = \App\Models\Individual::find($user_request->individual_id);
                                    }

                                    else
                                    {
                                        $user = \App\Models\Institution::find($user_request->institution_id);
                                    }

                                    $inventories  = \App\Models\Inventory::where(['project_id' => $user_request->project_id])->get();
            
                                    $projects = $user_request->projects;
                                @endphp
                            @endif

                            <!-- Adding / Editing -->
                            <div class="form-group  col-md-3 ">
                                    <label class="control-label" for="name">Name</label>
                                    <input type="text" class="form-control" value="{{$user->name}}" readonly>
                            </div>

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Project</label>
                                @foreach($projects as $item)
                                <input type="text" class="form-control" value="{{$item->title}}" readonly>
                                @endforeach
                            </div>

                            @if($user_request->individual_id)
                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Gender</label>
                                <input type="text" class="form-control" value="{{$user->gender}}" readonly>
                            </div>

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Age</label>
                                <input type="text" class="form-control" value="{{$user->age}}" readonly>
                            </div>
                            @else

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Contact Person</label>
                                <input type="text" class="form-control" value="{{$user->contact_person}}" readonly>
                            </div>

                            @endif

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Phone</label>
                                <input type="text" class="form-control" value="{{$user->contact_number}}" readonly>
                            </div>

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Province</label>
                                <input type="text" class="form-control" value="{{ optional($user->province)->title_en}}" readonly>
                            </div>

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">District</label>
                                <input type="text" class="form-control" value="{{ optional($user->district)->title_en}}" readonly>
                            </div>

                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="name">Local Level</label>
                                <input type="text" class="form-control" value="{{ optional($user->localLevel)->title_en }}" readonly>
                            </div>

                            <div class="form-group  col-md-12 ">
                                <label class="control-label" for="name">Message</label>
                                <textarea name="details" class="form-control" rows="5" cols="20" readonly> {{$user_request->details}} </textarea>
                            </div>
                            <div class="form-group  col-md-12 ">
                                <label class="control-label" for="name">Respond Date</label>
                                  <vuejs-datepicker v-model="dataTypeContent.created_at"></vuejs-datepicker>
                            </div>
                            <div v-for="(item,index) in respondedItems">
                                <div class="form-group  col-md-6 ">
                                        <label class="control-label" for="name">Select Item</label>
                                        <select class="form-control" v-model="item.inventory_id">
                                            <option value="-1" selected="selected" disabled>Select Items</option>
                                            <option :value="inventory.id" v-for="inventory in inventories">@{{ inventory.title }}</option>
                                        </select>
                                </div>
                                <div class="form-group  col-md-2 ">
                                    <label class="control-label" for="name">Quantity</label>
                                    <input required type="number" class="form-control" v-model.number="item.quantity" >
                                </div>
                                <div class="form-group  col-md-3 ">
                                    <label class="control-label" for="name">Unit</label>
                                    <input required type="text" class="form-control" v-model.number="item.unit" >
                                </div>




                                <div class="form-group  col-md-1" v-if="index!=0">
                                    <label class="control-label" for="name"></label>
                                    <input  class="btn btn-danger" type="button" v-on:click="deleteItem(index)" value="Delete">
                                </div>

                            </div>


                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <input :disabled="submitting" v-on:click="addItem" class="btn btn-success" type="button" value="Add Items">

                            @section('submit-buttons')
                                <button :disabled="submitting" v-on:click="submitData" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop

                            @yield('submit-buttons')
                            <input :disabled="submitting" onclick="window.location=document.referrer;" class="btn btn-secondary" type="button" value="Back">

                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.6.2/vuejs-datepicker.min.js" integrity="sha512-SxUBqfNhPSntua7WUkt171HWx4SV4xoRm14vLNsdDR/kQiMn8iMUeopr8VahPpuvRjQKeOiMJTJFH5NHzNUHYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var app = new Vue({
            el: '#app',
            components: {
                vuejsDatepicker
            },
            data: {
                iterations:1,
                inventories: @json($inventories),
                respondedItems: [
                    {
                        inventory_id: -1,
                        quantity: 0,
                        unit:""
                    }
                ],
                dataTypeContent:{},
                submitting: false
            },
            mounted(){
                @if($edit)
                    this.respondedItems = @json($modelInventories);
                    this.dataTypeContent = @json($dataTypeContent);
                @endif
            },
            methods:{
                customFormatter(date) {
                     return moment(date).format('m/d/Y g:i A');
                },
                addItem(){
                    this.respondedItems.push({
                        inventory_id: -1,
                        quantity: 0,
                        unit:""
                    });
                },
                deleteItem(index){
                    this.respondedItems.splice(index,1);
                },
                submitData(e){
                    e.preventDefault();
                    this.submitting = true;
                    tempthis = this;
                    axios.post('{{ route("add_response") }}',
                    {
                        '_token':'{{ csrf_token() }}',
                        'responded_items': this.respondedItems,
                        'individual_id':@json($user_request->individual_id),
                        'institution_id':@json($user_request->institution_id),
                        'user_request_id':@json($user_request->id),
                        'responses': this.dataTypeContent,
                        'response_id': '{{ $dataTypeContent->id }}'
                    }).then((response) => {
                        tempthis.submitting = false;
                        window.location=document.referrer;
                    })
                }
            }
        })
    </script>

    <script>
        $('.vdp-datepicker>div>input').addClass('form-control');
    </script>
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
