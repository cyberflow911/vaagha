<?php 
	require_once '../lib/core.php';
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(isset($_POST['reg-num'])&&isset($_POST['com-name'])&&isset($_POST['address'])&&isset($_POST['traddress'])&&isset($_POST['post'])&&isset($_POST['cpost'])&&isset($_POST['vat'])&&isset($_POST['first-name'])&&isset($_POST['last-name'])&&isset($_POST['email'])&&isset($_POST['password']))
		{
			$reg_num = $_POST['reg-num'];	
			$com_name = $_POST['com-name'];
			$address = $_POST['address'];
			$tr_address = $_POST['traddress'];
			$post = $_POST['post'];
			$cpost = $_POST['cpost'];
			$vat = $_POST['vat'];
			$first_name = $_POST['first-name'];
			$last_name = $_POST['last-name'];
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$sql="INSERT INTO companies(reg_num,com_name,address,cpost,tr_address,post,vat,status) VALUES('$reg_num','$com_name','$address','$cpost','$tr_address','$post','$vat','2')";
			if($conn->query($sql))
			{
				$com_id = $conn->insert_id;
				$sql="INSERT INTO com_admins(c_id,f_name,l_name,email,password,status,type) values('$com_id','$first_name','$last_name','$email','$password','1','1')";
				if($conn->query($sql))
				{
					$register_success = true;
					$token = md5("success");
					header("Location:index?token=$token");
				}
				else
				{
					$register_error = $conn->error; 
				}
			}
			else
			{
				$register_error = $conn->error;
			}
		}
	}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register</title>
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="css/opensans-font.css">
    <link rel="stylesheet" type="text/css"
        href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css?token=1" />
    <!-- bootstrap -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <style>
    input:focus,
    textarea:focus,
    select:focus,
    button:focus {
        outline: none;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert {
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }

    input,
    textarea {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        font-size: 14px;
    }

    label,
    legend {
        font-family: 'Open Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #999;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }



    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        margin: 10px;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }



    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>
</head>

<body>

    <div class="page-content">

        <div class="form-v1-content">

            <div class="wizard-form">
                <form class="form-register" action="#" method="post" id="register-form">
                    <div id="form-total">
                        <!-- SECTION 1 -->
                        <h2>
                            <p class="step-icon"><span>01</span></p>
                            <span class="step-text">Company Infomation</span>

                        </h2>
                        <section>
                            <div class="inner" id="company-infomation">
                                <div class="wizard-header">
                                    <?php
										if(isset($register_success))
										{
									?>
                                    <div class="alert alert-success" role="alert">
                                        Company Registered successfully
                                    </div>
                                    <?php
										}
										else if(isset($register_error))
										{
									?>
                                    <div class="alert alert-danger" role="alert">
                                        Unable To Register Company! Try again later
                                    </div>
                                    <?php
										}
									?>

                                    <h3 class="heading">Company Infomation</h3>
                                    <p>Please enter your Company infomation and proceed to the next step so we can build
                                        your Company account.</p>

                                </div>
                                <div class="form-row">
                                    <div class="form-holder">
                                        <fieldset>
                                            <legend>Company Reg. Number</legend>
                                            <div class="autocomplete">
                                                <input type="text" class="form-control" oninput="check(this)"
                                                    id="reg-num" name="reg-num"  placeholder="Company Reg. Number">
                                            </div>
                                            <!-- <input type="number" class="form-control" oninput="check(this)" id="reg-num" name="reg-num" placeholder="Company Reg. Number"> -->

                                        </fieldset>
                                        <button class="btn btn-info" type="button" onclick="searchCompany($('#reg-num').val())">Search</button>
                                    </div>
                                    <div class="form-holder">
                                        <fieldset>
                                            <legend>Company Name</legend>
                                            <input type="text" class="form-control" id="com-name" name="com-name"
                                                placeholder="Company Name" required>
                                        </fieldset>
                                        <!-- <button class="btn btn-info" type="button">Search</button> -->
                                    </div>
                                </div>
								<div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Registered Address</legend>
                                            <textarea id="traddress" name="traddress"
                                                placeholder="Company Trading Address" class="form-control" rows="3"
                                                style="resize: none;width: 100%;border:none;" required></textarea>
                                        </fieldset>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Post Code</legend>
                                            <input type="text" class="form-control" id="post" name="post"
                                                placeholder="AB12CD" required pattern="[a-zA-Z0-9]">
                                        </fieldset>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-xs-8">
                                        <br><input type="checkbox" id="traddresscheck" name="traddresscheck">
                                        <label for="traddresscheck">Same as registered address</label>
                                    </div>
                                </div>

								<div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Communication Address</legend>
                                            <textarea id="address" name="address" placeholder="Company Address"
                                                class="form-control" rows="3"
                                                style="resize: none;width: 100%;border:none;" required></textarea>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Post Code</legend>
                                            <input type="text" class="form-control" id="cpost" name="cpost"
                                                placeholder="AB12CD" required pattern="[a-zA-Z0-9]">
                                        </fieldset>
                                    </div>
                                </div>
                               
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>VAT</legend>
                                            <input type="text" class="form-control" id="vat" name="vat"
                                                placeholder="VAT">
                                        </fieldset>

                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- SECTION 2 -->
                        <h2>
                            <p class="step-icon"><span>02</span></p>
                            <span class="step-text">Admin Information</span>
                        </h2>
                        <section>
                            <div class="inner" id="admin-infomation">
                                <div class="wizard-header">
                                    <div class="alert alert-danger" role="alert" style="display:none" id="alert_user">
                                        Unable To Register Company! Try again later
                                    </div>
                                    <h3 class="heading">Administrator Information</h3>
                                    <p>Please enter Administrator infomation and proceed to the next step so we can
                                        build your Company accounts.</p>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder">
                                        <fieldset>
                                            <legend>First Name</legend>
                                            <input type="text" class="form-control" id="first-name" name="first-name"
                                                placeholder="First Name" required>
                                        </fieldset>
                                    </div>
                                    <div class="form-holder">
                                        <fieldset>
                                            <legend>Last Name</legend>
                                            <input type="text" class="form-control" id="last-name" name="last-name"
                                                placeholder="Last Name" required>
                                        </fieldset>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Email Address</legend>
                                            <input type="email" name="email" id="email" class="form-control"
                                                pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com"
                                                required>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Verify Email Address</legend>
                                            <input type="email" name="re_email" id="re_email" class="form-control"
                                                pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com"
                                                required>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Password</legend>
                                            <input type="password" name="password" id="password" class="form-controle"
                                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" required>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <fieldset>
                                            <legend>Verify Password</legend>
                                            <input type="password" name="re_password" id="re_password"
                                                class="form-controle" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" required>
                                        </fieldset>
                                    </div>
                                </div>

                            </div>

                        </section>
                        <p style="position:absolute;bottom:-1%;margin-left:10px">Already Registered <a
                                href="index">Click Here</a></p>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl2Zq1Xr7l1qLT2INlKwvlpsFnlTa3D58&libraries=places"></script> -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.steps.js"></script>
    <script src="js/main.js?token=2"></script>
    <script>
    var companies = [];
    var companyDetails = [];
    var xhrRequest;
    $(document).ready(function() {
        $('input[type="checkbox"]').click(function() {
            if ($(this).prop("checked") == true) {
                var address = $("#traddress").val();

                $("#address").html(address);
                $("#cpost").val($("#post").val())
            } else if ($(this).prop("checked") == false) {
                $("#address").html("");
                $("#cpost").val("");
            }
        });


        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        // autocomplete(document.getElementById("reg-num"), "number");
        autocomplete(document.getElementById("com-name"), "name");

    });


    function check(input) {
        var x = $(input).val();
        var len = x.toString().length;
        if (len < 8 || len > 8) {
            input.setCustomValidity('The number must be equals to 8.');
        }
    }

    function autocomplete(inp, mode) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {

            var a, b, i, val = this.value;
            console.log(val)
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/

            if (xhrRequest) {
                xhrRequest.abort()
            }

            xhrRequest = $.ajax({
                url: 'company_search_ajax.php',
                type: "POST",
                data: {
                    companyName: val
                },
                success: function(data) {
                    // console.log(data)

                    var obj = JSON.parse(data);
                    console.log(obj)
                    companies = obj.items;
                    var arr = [];
                    obj.items.map(function(item) {
                        arr.push(item.title);
                    })
                    for (i = 0; i < arr.length; i++) {
                        /*check if the item starts with the same letters as the text field value:*/
                        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function(e) {
                                /*insert the value for the autocomplete text field:*/
                                var elementValues = this.getElementsByTagName("input")[0]
                                    .value;
                                inp.value = elementValues;
                                companyDetails = companies.filter(function(item) {
                                    return item.title == elementValues
                                });
                                console.log(companyDetails);
                                $("#traddress").val(companyDetails[0].address_snippet)
                                $("#reg-num").val(companyDetails[0].company_number)
                                $("#post").val(companyDetails[0].address.postal_code);
                                // address

                                /*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }


                },
                error: function(err) {
                    console.log(err);
                }
            })

        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }

    function searchCompany(val)
    {
        $.ajax({
            url:"company_search_ajax.php",
            type:"POST",
            data: {
                companyNumber:val
            },
            success: function(data)
            {
                var obj = JSON.parse(data);
                console.log(obj)
                $("#com-name").val(obj.company_name)
                $("#traddress").val(obj.registered_office_address.address_line_1+","+obj.registered_office_address.locality+","+obj.registered_office_address.region+","+obj.registered_office_address.country+","+obj.registered_office_address.postal_code) 
                $("#post").val(obj.registered_office_address.postal_code);
            },
            error: function(data)
            {

            }
        })
    } 
    </script>
</body>

</html>