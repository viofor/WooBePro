@extends('layouts.appverify')
    
@section('content')
<script type="text/javascript">
  $(document).ready(function(){
    $("#user").change(function(){
      var usertype = $("#user").val();
      if (usertype == '2') {
        $("#proform").show();
      }else {
        $("#proform").hide();
      }
    });
    /*///////////////////////////////////////////////////////////////////////////////////////////
    The following function removes the selected skill from user's skills.
    ///////////////////////////////////////////////////////////////////////////////////////////*/
    $(".skill").click(function(e){
      var deleted = e.target.nextSibling.data;
      var current = $("#skill").val();
      var New = current.replace(deleted+",", "");
      $("#skill").val(New);
    });

    /*///////////////////////////////////////////////////////////////////////////////////////////
    The following function adds the submitted skill to user's skills.
    ///////////////////////////////////////////////////////////////////////////////////////////*/

    $("button.ml-5").click(function(){
      var skillentryval = $("button.ml-5")[0].form[10].value;
      if (skillentryval == "") {
        alert("Input a skill");
      }else {
        var current = $("#skill").val();
        var array = current.concat(skillentryval+",");
        $(".skilllist").append("<div class=''><div class='alert alert-primary'><a class='close skill' data-dismiss='alert' aria-label='close' onclick='deleteNewElement(this)'>&times;</a>"+skillentryval+"<br></div></div>");
        $("#skill").val(array);     //This is the value to be sended to the table
        $("button.ml-5")[0].form[10].value = "";
      }
    });
  });

  function deleteNewElement(x){
    var deleted = x.nextSibling.data;
    var current = $("#skill").val();
    var New = current.replace(","+deleted, "");
    $("#skill").val(New);
  }
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome to WooBe!
                    <br>
                    Please fill all the data requested below in order to continue with the registration.
                </div>
                @if(!empty($errors->first()))
                    <div class="row col-lg-12">
                        <div class="alert alert-danger">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form method="GET" action="{{route('profile.create')}}">
                {{ csrf_field() }}
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                  </div>
                  <div class="form-group">
                    <label for="country">Country</label>
                    <select class="form-control" id="country" name="country">
                      @include('layouts.options.countries')
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control" name="state" id="state" placeholder="State">
                  </div>
                  <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="City">
                  </div>
                  <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" name="street" id="street" placeholder="Street">
                  </div>
                  <div class="form-group">
                    <label for="user">Type of user</label>
                    <select class="form-control" id="user" name="usertype">
                      <option value="1">Client</option>
                      <option value="2">Professional</option>
                    </select>
                  </div>
                  <div id="proform" style="display: none;">
                    <div class="form-group">
                        <label for="schedule">Schedule</label>
                        <input type="text" class="form-control" name="schedule" id="schedule" placeholder="Schedule of work">
                    </div>
                    <div class="form-group">
                        <label for="resume">Resume</label>
                        <textarea class="form-control" name="resume" id="resume" rows="3" placeholder="Give a resume about yourself"></textarea>
                    </div>
                    <div class='form-group'>
                      <label for='skills'>Skills</label>
                      <p>Skills on your profile: </p>
                      <div class='container'>
                        <div class='row skilllist'>
                        </div>
                      </div>
                      <input id='skill' name='skill' style='display:none;'></input>
                      <input class='form-control' placeholder='Input your skill here'></input>
                    </div>
                    <button type='button' class='btn btn-primary ml-5 mb-5'>Add skill</button>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection