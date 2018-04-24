@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><b>Create New Event</b></h3>
      </div>
      <form method="post" action="/events/new">
        {{ csrf_field() }}
      <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

          <div class="form-group">
              <label class="form-label">Select sport *</label>
              <div class="selectgroup selectgroup-pills">
                @foreach ($sports as $sport)
                  <label class="selectgroup-item">
                    <input type="radio" name="sport" value="{{$sport->id}}" class="selectgroup-input">
                    <span class="selectgroup-button">{{$sport->name}}</span>
                  </label>
                @endforeach
              </div>
            </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Number players total *</label>
                <input name="players_total" type="number" class="form-control" placeholder="10" required>
                <small class="form-text text-muted">Number of players to play in total including you</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Number players confirmed *</label>
                <input name="players_confirmed" type="number" class="form-control" placeholder="6" required>
                <small class="form-text text-muted">Number of players already attending excluding you </small>
              </div>
            </div>
            <div class="col-md-4">

              <div class="form-group">
                <label class="form-label">Cost *</label>
                <input type="text" name="cost" class="form-control" placeholder="0.00" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" required>
                <small class="form-text text-muted">Cost per player</small>
              </div>

            </div>

          </div>

          <label class="form-label">Location *</label>

          <input id="pac-input" class="form-control mb-2" name="local" type="text" placeholder="Enter a location" required>
          <div id="map" class="mb-4"></div>

          <div class="row">

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Date *</label>
                <input type='text' id="date" name="date" class="form-control" placeholder="dd/mm/yyyy" readonly required>
                <script>
                  $('#date').datepicker({
                      language: 'en',
                      minDate: new Date()
                    });
                </script>
              </div>
          </div>

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Time start *</label>
                <input type="text" name="time_start"  placeholder="hh:mm" class="only-time time_start form-control" required="true" readonly="true">
                <script>
                  $('.time_start').datepicker({
                    dateFormat: ' ',
                    timepicker: true,
                    classes: 'only-timepicker'
                  });
                </script>
                <style>
                  .only-timepicker .datepicker--nav,
                  .only-timepicker .datepicker--content {
                      display: none;
                  }
                  .only-timepicker .datepicker--time {
                      border-top: none;
                  }
                </style>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Time end *</label>
                <input type="text" name="time_end" class="time_end only-time form-control" placeholder="hh:mm" required readonly>
                <script>
                  $('.time_end').datepicker({
                    dateFormat: ' ',
                    timepicker: true,
                    classes: 'only-timepicker'
                  });
                </script>
                <style>
                  .only-timepicker .datepicker--nav,
                  .only-timepicker .datepicker--content {
                      display: none;
                  }
                  .only-timepicker .datepicker--time {
                      border-top: none;
                  }
                </style>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Title </label>
            <input type="text" class="form-control" name="title" placeholder="Title" >
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
          </div>

      </div>
      <div class="card-footer text-right">
          <div class="d-flex">
            <a href="/games" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary ml-auto">Post now</button>
          </div>
        </div>
        </form>
    </div>




  </div>

  <style>

      #map {
        height: 300px;
      }

    </style>

  <script>

  $(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('pac-input'));

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {

            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD22LYxp8jsIshXVBidtMaBg76tdfcVovM&libraries=places&callback=initMap" async defer></script>

@endsection
