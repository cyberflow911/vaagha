$(function(){
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: false,
        stepsOrientation: "vertical",
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate : '<div class="title">#title#</div>',
        labels: {
            previous : 'Back Step',
            next : `<button class="btn btn-success" style="background:none;border:none;color:white" onclick="validate_fields('company-infomation')"><i class="zmdi zmdi-arrow-right"></i></button`,
            finish : `<button style="background:none;border:none;color:white" onclick="submit_regis_form()"><i style="font-size:20px" class="zmdi zmdi-check"></i></button>`,
            current : ''
        },
    })

    // google.maps.event.addDomListener(window, 'load', initialize);
    
});

function submit_regis_form(){
    if(validate_fields('admin-infomation'))
    {
        var res  = verify_credentials()
        if(res==='ok')
        {
            $("#register-form").submit();
        }
        else
        {
            $("#alert_user").html(res).css("display","block");

        }
        
    }
    else
    {
        
        $("#alert_user").html("Some Fields Are Empty").css("display","block"); 
    }
}

function validate_fields(id){ 
    let allAreFilled = true;
    document.querySelectorAll("[required]").forEach(function(i) {
      if (!allAreFilled) return;
      if (!i.value) allAreFilled = false;
      if (i.type === "radio") {
        let radioValueCheck = false;
        document.querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
          if (r.checked) radioValueCheck = true;
        })
        allAreFilled = radioValueCheck;
      }
    })
     
    return allAreFilled;
}

function verify_credentials()
{
    var email = $("#email").val();
    var password = $("#password").val();
    var re_email = $("#re_email").val();
    var re_password = $("#re_password").val();
    if(email!==re_email)
    {
            return "Email Mismatched";
    }
    if(password!==re_password)
    {
        return "Password Mismatched";
    }
    
    return "ok";
}

// function onSubmit(token) {
//     document.getElementById("demo-form").submit();
//   }

   
//     function initialize() {
//         var input = document.getElementById('address');
//         var autocomplete = new google.maps.places.Autocomplete(input);
//     }