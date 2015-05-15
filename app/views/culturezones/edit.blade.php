{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Modifier une zone de culture @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<style>
#map {
  min-height: 600px;
  border: 1px solid #000;
}    
</style>
@endsection

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
<script>
window.onload = function() {
    var latlng = new google.maps.LatLng({{$culturezone->longitude}}, {{$culturezone->latitude}});
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 11,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: '{{$culturezone->name}}',
        draggable: true
    });
    google.maps.event.addListener(marker, 'dragend', function(a) {
        console.log(a);
        var div = document.createElement('div');
        div.innerHTML = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4);
        document.getElementsByTagName('body')[0].appendChild(div);
    });
};
</script>
@endsection

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Modifier la zone  {{ $culturezone->name }} </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                     Merci de remplir le formulaire ci-dessous
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ( $errors->count() > 0 )
                                @foreach( $errors->all() as $message )
                                    <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                @endforeach
                            @endif
                              {{ Form::open(array('url' => URL::to('culturezone/update') , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('name') != '') has-error @endif">
                                    <label>Nom *</label>
                                    {{ Form::text('name', $culturezone->name, array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('name', '<span class="error">:message</span>' ) }}
                                </div>
                               
                                <div class="form-group">
                                    <label>Longitude</label>
                                    {{ Form::text('longitude', $culturezone->longitude, array('class' => 'form-control','readonly'=>'true')) }}
                                </div>
                                
                                   <div class="form-group">
                                    <label>Latitude</label>
                                    {{ Form::text('latitude', $culturezone->latitude, array('class' => 'form-control','readonly'=>'true')) }}
                                </div>
                                
                                <div class="form-group">
                                    <label>Description</label>
                                    {{ Form::textarea('description', $culturezone->description, array('class' => 'form-control')) }}
                                </div>
                                 {{ Form::hidden('id', $culturezone->id) }}
                                {{ Form::submit('Modifier', array('class'=>'btn btn-primary')) }}
                                {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                            {{ Form::close() }}
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-4 -->
                <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Localisation Geographique
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                             <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                               <div id="map"></div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@endsection