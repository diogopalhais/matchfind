<?php $__env->startSection('content'); ?>

  <div class="container">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit game</h3>
      </div>
      <form method="post" action="/events/<?php echo e($game->id); ?>/edit">
        <?php echo e(csrf_field()); ?>

      <div class="card-body">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

          <div class="form-group">
              <label class="form-label">Sport *</label>
              <div class="selectgroup selectgroup-pills">
                <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <label class="selectgroup-item">
                    <input type="radio" name="sport" value="<?php echo e($sport->id); ?>" class="selectgroup-input" <?php if($game->sport->id == $sport->id): ?> checked <?php endif; ?>>
                    <span class="selectgroup-button"><?php echo e($sport->name); ?></span>
                  </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Number players total *</label>
                <input name="players_total" type="number" value="<?php echo e($game->num_players); ?>" class="form-control" placeholder="10" required>
                
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Number players confirmed *</label>
                <input name="players_confirmed" value="<?php echo e($game->num_players_confirmed); ?>" type="number" class="form-control" placeholder="6" required>
                
              </div>
            </div>
            <div class="col-md-4">

              <div class="form-group">
                <label class="form-label">Cost per player *</label>
                <input type="text" name="cost" value="<?php echo e($game->cost); ?>" class="form-control" placeholder="0.00" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" required>
              </div>

            </div>

          </div>

          <label class="form-label">Location *</label>
          <input id="pac-input" class="controls" name="local" type="text" value="<?php echo e($game->local); ?>" placeholder="Enter a location" required>
          <div id="map" class="mb-4"></div>

          <div class="row">

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Date *</label>
                <input type="date" name="date" class="form-control" value="<?php echo e($game->date); ?>" data-inputmask-alias="date" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy" required>
                
              </div>
          </div>

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Time start *</label>
                <input type="text" name="time_start" class="form-control" value="<?php echo e($game->time_start); ?>" data-inputmask-alias="hh:mm" data-inputmask-inputformat="hh:mm" placeholder="hh:mm" required>
                
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Time end *</label>
                <input type="text" name="time_end" class="form-control"  value="<?php echo e($game->time_end); ?>" data-inputmask-alias="hh:mm" data-inputmask-inputformat="hh:mm" placeholder="hh:mm" required>
                
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Title </label>
            <input type="text" class="form-control" name="title" value="<?php echo e($game->title); ?>" placeholder="Title" >
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3"><?php echo e($game->description); ?></textarea>
          </div>

      </div>
      <div class="card-footer text-right">
          <div class="d-flex">
            <a href="/games/<?php echo e($game->id); ?>" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary ml-auto">Update now</button>
          </div>
        </div>
        </form>
    </div>




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

      $(document).ready(function(){
        $(":input").inputmask();
      });

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>