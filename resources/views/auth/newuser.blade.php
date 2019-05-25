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
  });
  
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
                      @include('layouts.countries')
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
                    <div class="form-group">
                        <label for="skills">Skills</label>
                        <textarea class="form-control" name="skill" id="skills" rows="3" placeholder="Tell us your skills"></textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection