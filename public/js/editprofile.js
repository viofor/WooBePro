  var detail = {!! $country !!};   //Getting the country id value from Laravel controller
  var country = detail - 1;        //Arrays begin with index 0

  $(document).ready(function(){
    $('option')[country].setAttribute("selected", "selected");  //I get the current user country selected

    var detailshowhandle = {!! json_encode($detail->toArray()) !!}[0].skill;
    var newarray = detailshowhandle.split(",");
    $("#skill").val(detailshowhandle);

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
      var skillentryval = $("button.ml-5")[0].previousSibling.lastChild.value;
      if (skillentryval == "") {
        alert("Input a skill");
      }else {
        var current = $("#skill").val();
        var array = current.concat(skillentryval+",");
        $(".skilllist").append("<div class=''><div class='alert alert-primary'><a class='close skill' data-dismiss='alert' aria-label='close' onclick='deleteNewElement(this)'>&times;</a>"+skillentryval+"<br></div></div>");
        $("#skill").val(array);     //This is the value to be sended to the table
        $("button.ml-5")[0].previousSibling.lastChild.value = "";
      }
    });

  });
  function deleteNewElement(x){
    var deleted = x.nextSibling.data;
    var current = $("#skill").val();
    var New = current.replace(","+deleted, "");
    $("#skill").val(New);
  }