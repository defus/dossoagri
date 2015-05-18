@extends('templates.normal')

{{-- Page title --}}
@section('title') Liste des zones de  cultures @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<!-- DataTables CSS -->
{{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
{{ HTML::style('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/css/dataTables.tableTools.min.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/js/dataTables.tableTools.min.js') }}
<style>
#map
{
  min-height: 900px;
  width:100%;        
}

#page-wrapper
{
    padding: 0 !important;
}

.fill { 
    min-height: 100%;
    height: 100%;
}
#map {
  position:absolute;z-index:1;
}
.overlap{
  position: relative;
  z-index:2;
  background: white;
  ri
}

#search-card {
 
}
.card .header {
  position: absolute;
  right: 0;
  top: 50px;
  left: auto;
  z-index: 10;
  width: 100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  background: #00c1ac;
  color: #fff;
  height: 56px;
  -webkit-transform: translate(100%, 0);
  -ms-transform: translate(100%, 0);
  transform: translate(100%, 0);
  -webkit-transition: .3s;
  transition: .3s;
  -webkit-transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
  transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
}
.card .content {
  width: 448px;
  padding-top: 64px;
}
.card .content {
  background: #fff;
  position: absolute;
  z-index: 2;
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  top: 0;
  bottom: 0;
  left: auto;
  right: 0;
  width: 100%;
  padding-top: 56px;
  -webkit-transform: translate(100%, 0);
  -ms-transform: translate(100%, 0);
  transform: translate(100%, 0);
  -webkit-transition: .3s;
  transition: .3s;
  -webkit-transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
  transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
}
</style>


<script>
// The following example creates complex markers to indicate beaches near
// Sydney, NSW, Australia. Note that the anchor is set to
// (0,32) to correspond to the base of the flagpole.

function initialize() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(13.525120, 2.107531)
  }
  var map = new google.maps.Map(document.getElementById('map'),
                                mapOptions);

  setMarkers(map, beaches);
}

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */
var beaches = [
     @foreach($waterpoints as $key => $value)
        ['{{$value->name}}',{{$value->latitude}}, {{$value->longitude}},{{$key+ 1}}],
     @endforeach
];

function setMarkers(map, locations) {
  // Add markers to the map

  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.

  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  var image = {
    url: '/assets/images/cultureFlag.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(32, 32),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon.
  // The type defines an HTML &lt;area&gt; element 'poly' which
  // traces out a polygon as a series of X,Y points. The final
  // coordinate closes the poly by connecting to the first
  // coordinate.
  var shape = {
      coords: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };
  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        shape: shape,
        title: beach[0],
        zIndex: beach[3]
    });
  }
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

@endsection

{{-- Page content --}}

@section('content')
<div id="page-wrapper">
    



                    <!-- MAP -->
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                    <div id="map"></div>
                    <!-- END MAP -->

     
    <div class="card container overlap" id="search-card">
            <div class="header">
                <div class="cancel icon-btn waves-effect"><i class="icon-close"></i>
                </div>
                <div class="icon-btn">
                    <i class="icon-search"></i>
                </div>
                <form action="/api/v1/searches">
                    <input autocomplete="off" class="ghost" name="query" placeholder="Search for a location..." type="text">
                </form>
            </div>
            <div class="content">
                <ul class="toggle-list results" style="display: none"></ul>
            </div>
    </div>
   

</div>
<!-- /#page-wrapper -->

@endsection
