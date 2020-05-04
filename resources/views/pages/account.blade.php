@extends('dashboard')
@section('content')

<div class="x_content">
  
  <br />
  <form id="form" class="form-horizontal form-label-left" method="post" action="{{ route('update_employee') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="first_name" name="first_name" value="{{ $data->first_name }}" class="form-control col-md-7 col-xs-12">
        <input type="hidden" name="id" value="{{ $data->id }}"></input>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="last_name" name="last_name" value="{{ $data->last_name }}" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="email" name="email" value="{{ $data->email }}" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="phone" name="phone" value="{{ $data->phone }}" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea name="address" id="address" class="form-control col-md-7 col-xs-12">{{ $data->address }}</textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Location <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input name="location" id="location" onkeyup="myFunction()" value="{{ $data->location }}" class="form-control col-md-7 col-xs-12"></input>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Lat/Lng <span class="required">*</span>
      </label>
      <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="text" id="lat" name="lat" value="{{ $data->lat }}" class="form-control col-md-7 col-xs-12">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="text" id="lng" name="lng" value="{{ $data->lng }}" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <div id="map-canvas" style="width: 100%; height: 300px; align:center"></div>
        </div>
    </div>
    
    <!--<div class="form-group">-->
    <!--  <label class="control-label col-md-3 col-sm-3 col-xs-12">Image <span class="required">*</span>-->
    <!--  </label>-->
    <!--  <div class="col-md-6 col-sm-6 col-xs-12">-->
    <!--    <input id="image" class="form-control col-md-7 col-xs-12" name="image"  type="file">-->
    <!--  </div>-->
    <!--</div>-->
    <div class="ln_solid"></div>
    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </div>
  </form>
</div>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCWVwtYsL7a8pxq5V2xigxvgtDG25KOwM4&sensor=true" type="text/javascript"></script>

<script type="text/javascript">
  $('#form').submit(function(e){
    $('.error').remove()
    var success = true
    var first_name = $('#first_name').val()
    var last_name = $('#last_name').val()
    var email = $('#email').val()
    var phone = $('#phone').val()
    var address = $('#address').val()
    //var image = $('#image').val()
    if(first_name == ''){
      success = false
      $('#first_name').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(last_name == ''){
      success = false
      $('#last_name').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(email == ''){
      success = false
      $('#email').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(phone == ''){
      success = false
      $('#phone').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(address == ''){
      success = false
      $('#address').after("<span class='error' style='color:red'>Field is required</span>")
    }
    // if(image == ''){
    //   success = false
    //   $('#image').after("<span class='error' style='color:red'>Field is required</span>")
    // }

    if(success == false){
      e.preventDefault()
    }
  })
</script>

<script type="text/javascript">

       var map;
       var geocoder;
       var marker;
       var bord_data  = new Array();
       var latlng;
       var infowindow;
       var markers = [];

       $(document).ready(function() {
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            
           ViewCustInGoogleMap(lat,lng);
       });

        function myFunction(){
                var addr = $('#location').val();
				//var rad = $('#rad').val();
				//alert(addr+" "+rad);
				codeAddress(addr,5);
            }
       function ViewCustInGoogleMap(lat,lng) {
            var lt = 37.090240
            var lg = -95.712891
            
            if(lat != ''){
                lt= lat
                lg= lng
            }
           var mapOptions = {
               center: new google.maps.LatLng(lt, lg),   // Coimbatore = (11.0168445, 76.9558321)
               zoom: 11,
               mapTypeId: google.maps.MapTypeId.ROADMAP
           };
           map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
           
           setMarker(lt,lg);
           
       }
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
    
    
       function setMarker(lat,lng ) {
           var mapOptions = {
               center: new google.maps.LatLng(lat, lng),   // Coimbatore = (11.0168445, 76.9558321)
               zoom: 11,
               mapTypeId: google.maps.MapTypeId.ROADMAP
           };
                map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
               
               if (lat) {
                   //alert(lat)
                   latlng = new google.maps.LatLng(lat,lng);
                   marker = new google.maps.Marker({
                       position: latlng,
                       map: map,
                       draggable: true,
                       html: "djsddj",
                      // icon: "images/marker/" + bord_data ["MarkerId"] + ".png"
                   });
                 
                   google.maps.event.addListener(marker, 'dragend', function(event) {
                       
                       //alert(marker.getPosition().lat())
                       $('#lat').val(marker.getPosition().lat())
                       $('#lng').val(marker.getPosition().lng())
                       $('#location').val(revCodeAddress(marker.getPosition().lat(),marker.getPosition().lng()))
                        revCodeAddress(marker.getPosition().lat(),marker.getPosition().lng())
                        
                   });
               }
               else {
                   alert("error");
               }
       }

       function codeAddress(addr,rad) {
           console.log(addr)
			//var address = document.getElementById("address").value;
			//var radius = document.getElementById("radiusSelect").value;
			geocoder.geocode( {'address': addr }, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					//map.setCenter(results[0].geometry.location);
					//searchStoresNear(results[0].geometry.location, rad);
					var lat = results[0].geometry.location.lat()
					var lng = results[0].geometry.location.lng()
					console.log(lat);
					$('#lat').val(lat)
                    $('#lng').val(lng)
                    setMarker(lat,lng )
				} else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
					//alert("Address not found/invalid.");
				} else { //uncommon error, probably used up quota
					//alert("Geocoding failed for following reason: " + status);
				}
			});	
		}
		
		function revCodeAddress(lt,lg){
		    var latlng = {lat: lt, lng: lg};
		    geocoder.geocode( {'location': latlng }, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					//map.setCenter(results[0].geometry.location);
					//searchStoresNear(results[0].geometry.location, rad);
					var addr = results[0].formatted_address
					$('#location').val(addr)
				} else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
					alert("Address not found/invalid.");
				} else { //uncommon error, probably used up quota
					alert("Geocoding failed for following reason: " + status);
				}
			});	
		}
	</script>
@endsection