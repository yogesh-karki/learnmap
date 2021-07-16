@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="analytics-container">
            
                <p style="border-radius:4px; padding:20px; background:#fff; margin:0; color:#999; text-align:center;">
                   TYPE YOUR MESSAGE HERE
                </p>          
                       
        </div>
    </div>   
@stop

