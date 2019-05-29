@extends('layouts.app')
    
@section('content')
<script type="text/javascript">
  var detail = {!! $country !!};   //Getting the country id value from Laravel controller
  var country = detail - 1;        //Arrays begin with index 0
  $(document).ready(function(){
    $('option')[country].setAttribute("selected", "selected");  //I get the current user country selected
    /*///////////////////////////////////////////////////////////////////////////////////////////
    The following function is intended to increase the protection against hackers messing with the form fields. Please take it as a suggestion. I also suggest to keep these kind of functions in a separate .js file included inside the <head> tag.
    ///////////////////////////////////////////////////////////////////////////////////////////*/
    /*///////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////This function updates the Basic info fields/////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////*/
    $("#updateprofileinfo1").click(function(e){
      e.preventDefault();   //Avoid to form submit by just hitting "Submit" button
      $("#updateprofileinfoform1").attr("action", "/profile/{{ Auth::user()->id }}"); //Setting the attribute "action" of form field (suggestion)
      $("#updateprofileinfoform1").submit(); //Submits the form
    });
    /*///////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////This function updates the Advanced info fields///////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////*/
    $("#updateprofileinfo2").click(function(e){
      e.preventDefault();   //Avoid to form submit by just hitting "Submit" button
      $("#updateprofileinfoform2").attr("action", "/profile"); //Setting the attribute "action" of form field (suggestion)
      $("#updateprofileinfoform2").attr("method", "POST");
      $("#updateprofileinfoform2").submit(); //Submits the form
    });
    /*///////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////This function uploads the video///////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////*/
    $("#uploadvideo").click(function(e){
      e.preventDefault();   //Avoid to form submit by just hitting "Submit" button
      $("#uploadvideoform").attr("action", "/profile/video"); //Setting the attribute "action" of form field (suggestion)
      $("#uploadvideoform").attr("method", "POST");
      $("#uploadvideoform").submit(); //Submits the form
    });
    /*///////////////////////////////////////////////////////////////////////////////////////////
    The following function drops down the form related to the section the user wants to edit.
    ///////////////////////////////////////////////////////////////////////////////////////////*/
    $("h4").click(function(e){
      $(this.nextElementSibling).toggle();
    });
  });
</script>
<!--
  If you want to see how the data arrives from Laravel controller to the views
  just uncomment this section. The data arrives as an object array
<?php
    echo $detail;
    echo "<br>";
    echo "user_id: ";
    echo $detail[0]->user_id;
    echo "<br>";
    echo "schedule: ";
    echo $detail[0]->schedule;
    echo "<br>";
    echo "country: ";
    echo $detail[0]->country;
    echo "<br>";
    echo $country;
    echo "<br>";
    echo $user;
?>
  I strongly recommend you to not include this comment section before submitting
  the webpage to the hosting
-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  Profile information
                </div>
                  <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <br>
                    Here you can edit all your profile info
                  </div>
                @if(!empty($errors->first()))
                    <div class="row col-lg-12">
                        <div class="alert alert-danger">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif
                <div class="container">
                  <h4 class="btn btn-primary container-fluid">Basic info</h4>
                  <div style="display: none;">
                    <form method="POST" id="updateprofileinfoform1">
                      <input type="hidden" name="_method" value="put" />
                       @csrf
                      <div class="form-group">
                        <label for="state">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $user->name;?>" placeholder="Name">
                      </div>
                        <div class="form-group">
                        <label for="state">Lastname</label>
                        <input type="text" class="form-control" name="lastname" value="<?php echo $user->lastname;?>" placeholder="Lastname">
                      </div>
                      <div class="form-group">
                        <label for="state">Phone number</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $user->phone;?>" placeholder="Phone number">
                      </div>
                      <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-control" name="country">
                          @include('layouts.options.countries')
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" name="state" value="<?php echo $detail[0]->state;?>" placeholder="State">
                      </div>
                      <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" value="<?php echo $detail[0]->city;?>" placeholder="City">
                      </div>
                      <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" name="street" value="<?php echo $detail[0]->street;?>" placeholder="Street">
                      </div>
                      <!---------------------------------------------------------
                      Here I check if the user is a professional.
                      If that's true, then the user will be allowed to edit
                      the schedule, resume and skills
                      ---------------------------------------------------------->
                      <?php
                        $usertype = $detail[0]->usertype;
                          if ($usertype == '2') {
                          echo "<div><div class='form-group'><label for='schedule'>Schedule</label><input type='text' class='form-control' name='schedule' value='";
                          echo $detail[0]->schedule;
                          echo "' placeholder='Schedule of work'></div><div class='form-group'><label for='resume'>Resume</label><textarea class='form-control' name='resume' rows='3' placeholder='Give a resume about yourself'>";
                          echo $detail[0]->resume;
                          echo "</textarea></div><div class='form-group'><label for='skills'>Skills</label><textarea class='form-control' name='skill' rows='3' placeholder='Tell us your skills'>";
                          echo $detail[0]->skill;
                          echo "</textarea></div></div>";
                        }
                      ?>
                      <button type="button" id="updateprofileinfo1" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
                <!--///////////////////////////////////////////////////////////////////
                  Advanced users section
                ////////////////////////////////////////////////////////////////////-->
                <?php
                $advanced = $user->advanced;
                if ($advanced == 1) {
                  echo "<div class='container mt-1'>
                  <h4 class='btn btn-primary container-fluid'>Advanced user info</h4>
                  <div style='display: none;'>
                    <form id='updateprofileinfoform2'>";
                       echo csrf_field();
                       echo "<div class='form-group'>
                        <label for='facebook'>Facebook account address</label>
                        <input type='text' class='form-control' name='facebook' placeholder='Facebook account address'>
                      </div>
                      <div class='form-group'>
                        <label for='twitter'>Twitter account address</label>
                        <input type='text' class='form-control' name='twitter' placeholder='Twitter account address'>
                      </div>
                      <div class='form-group'>
                        <label for='linkedin'>LinkedIn account address</label>
                        <input type='text' class='form-control' name='linkedin' placeholder='LinkedIn account address'>
                      </div>
                      <button type='button' id='updateprofileinfo2' class='btn btn-primary'>Submit</button>
                    </form>";
                    $usertype = $detail[0]->usertype;
                  if ($usertype == '2' && $canvideo == '1') {
                    echo "<div class='container mt-3'><form id='uploadvideoform' enctype='multipart/form-data'>";
                    echo csrf_field();
                    echo "<div class='form-group'>
                        <label for='video'>You can also upload a profile video here:</label>
                        <input type='file' class='form-control-file' name='video'>
                        <input type='text' style='display: none;' name='currentvid' id='currentvid'>
                      </div>
                      <p>*Only mp4 and webm files allowed</p>
                      <button type='button' id='uploadvideo' class='btn btn-primary'>Submit video</button>
                      </form></div>";
                  }
                  echo "</div>
                </div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection