<?php $__env->startSection('content'); ?>

  <div class="container">


      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Edit Profile</b></h3>
        </div>
        <div class="card-body">

          <form id="form" class="mt-4" method="post" action="/profile/edit" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>


            <div class="d-flex justify-content-start align-items-center">
              <span class="avatar avatar-xxl mr-4" style="background-image: url(<?php echo e(\Auth::user()->photo); ?>)"></span>
              <div class="form-group">
                  <label for="exampleFormControlFile1">Photo</label>
                  <input type="file" name="photo" class="form-control-file" id="exampleFormControlFile1">
                </div>
            </div>

            <div class="form-group mt-4">
              <label class="form-label">Name *</label>
              <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="<?php echo e(\Auth::user()->name); ?>" aria-describedby="emailHelp" placeholder="Enter name" required>
            </div>

            <div class="form-group">
              <label class="form-label">Location</label>
              <input id="pac-input" name="location" class="controls" type="text" value="<?php echo e(\Auth::user()->location); ?>" placeholder="Enter a location" >
              <div id="map"></div>

            </div>

            <div class="form-group">
             <label class="form-label">Sports</label>
             <select name="sports[]" multiple class="form-control">
               <?php $__currentLoopData = \App\Sport::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <option value="<?php echo e($sport->id); ?>"><?php echo e($sport->name); ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </select>
           </div>

        </div>
        <div class="card-footer text-right">
            <div class="d-flex">
              <a href="/profile" class="btn btn-link">Cancel</a>
              <button type="submit" class="btn btn-primary ml-auto">Save now</button>
            </div>
          </div>
        </form>
      </div>



      <style>

          #map {
            height: 400px;
          }

          .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
          }

          #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 300px;
          }

          #pac-input:focus {
            border-color: #4d90fe;
          }

          .pac-container {
            font-family: Roboto;
          }

          #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
          }

          #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
          }
        </style>

        <script>

        $(document).ready(function () {
          $('#form').on('keyup keypress', function(e) {
              var keyCode = e.keyCode || e.which;
              if (keyCode === 13) {
              e.preventDefault();
              return false;
              }
            });
        });

        </script>

        <script>

          function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: -33.8688, lng: 151.2195},
              zoom: 13
            });
            var input = /** @type  {!HTMLInputElement} */(
                document.getElementById('pac-input'));

            var types = document.getElementById('type-selector');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

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
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
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
              marker.setIcon(/** @type  {google.maps.Icon} */({
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

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
              var radioButton = document.getElementById(id);
              radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
              });
            }

            setupClickListener('changetype-all', []);
          }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD22LYxp8jsIshXVBidtMaBg76tdfcVovM&libraries=places&callback=initMap"
            async defer></script>


  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>