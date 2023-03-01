<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Business Flow Flare</title>     
<style>
.content {
    width: 60%;
    margin: 50px auto;
    padding: 20px;
  }
  .content h1 {
    font-weight: 400;
    text-transform: uppercase;
    margin: 0;
  }
  .content h2 {
    font-weight: 400;
    text-transform: uppercase;
    color: #333;
    margin: 0 0 20px;
  }
  .content p {
    font-size: 1em;
    font-weight: 300;
    line-height: 1.5em;
    margin: 0 0 20px;
  }
  .content p:last-child {
    margin: 0;
  }
  .content a.button {
    display: inline-block;
    padding: 10px 20px;
    background: #ff0;
    color: #000;
    text-decoration: none;
  }
  .content a.button:hover {
    background: #000;
    color: #ff0;
  }
  .content.title {
    position: relative;
    background: none;
    border: 2px dashed #333;
  }
  .content.title h1 span.demo {
    display: inline-block;
    font-size: .5em;
    padding: 5px 10px;
    background: #000;
    color: #fff;
    vertical-align: top;
    margin: 7px 0 0;
  }
  .content.title .back-to-article {
    position: absolute;
    bottom: -20px;
    left: 20px;
  }
  .content.title .back-to-article a {
    padding: 10px 20px;
    background: #f60;
    color: #fff;
    text-decoration: none;
  }
  .content.title .back-to-article a:hover {
    background: #f90;
  }
  .content.title .back-to-article a i {
    margin-left: 5px;
  }
  .content.white {
    background: #fff;
    box-shadow: 0 0 10px #999;
  }
  .content.black {
    background: #000;
  }
  .content.black p {
    color: #999;
  }
  .content.black p a {
    color: #08c;
  }
  
  .accordion-container {
    width: 100%;
    margin: 0 0 20px;
    clear: both;
  }
  .accordion-toggle {
    margin-bottom: 15px;
    position: relative;
    display: block;
    padding: 15px;
    font-size: 1.2em;
    font-weight: 300;
    background: #BBB;
    color: #fff;
    text-decoration: none;
    font-family: Bree serif !important;
  }
  .accordion-toggle.open {
    background:#BE971C;
    color: #fff;
  }
  .accordion-toggle:hover {
    background: #BE971C;
    color: #fff!important;
  }
  .accordion-toggle span.toggle-icon {
    position: absolute;
    top: 17px;
    left: 20px;
    font-size: 1.5em;
  }
  .accordion-content {
    display: none;
    padding: 20px;
    overflow: auto;
    font-family: Bree serif;
  }
  .accordion-content img {
    display: block;
    float: left;
    margin: 0 15px 10px 0;
    max-width: 100%;
    height: auto;
  }
  
  /* media query for mobile */
  @media (max-width: 767px) {
    .content {
      width: auto;
    }
    .accordion-content {
      padding: 10px 0;
      overflow: inherit;   
    }
  }      
</style>
<div class="container pages"> 
    <div class="row text-left" style="padding:10px;">   
    	<h2 style="text-align:center;"></h2>
        <div class="page-header"><h3>Service Listing</h3></div>
        <div class="page-header">Service Url : http://50.18.92.98/flare/api/business_service_info</div><br/>
		<div class="page-header">Base Url : http://50.18.92.98/flare/api</div><br/>              
<!-- *************************signup*********************************************** -->
	    <a href="#" class="accordion-toggle"><span class="toggle-icon"><i class="fa fa-plus-circle"></i></span>
	        <span style="margin-left:50px;line-height: 1.5em;">1.user_signup</span>
	    </a>
	    <div class="accordion-content">
	        <p> 
	            <h5>Parameters: </h5>
				{
					"user":{
						"first_name":"Rajiv",
						"last_name":"kumar",
						"email":"raj@gmail.com",
						"country_code":"+91",
						"phone_number":"8743892112",
						"social_id":"7896789789978ASAD",
						"device_type":"android",
						"device_token":"dfdfdfdsfdfdsfdsf",
						"signup_type":"facebook",
						"user_type":"2",
						"password":"123456",
						"lat":"27.5655",
						"log":"29.6565"
					}
				  }  
				
				In header (Content-Type- application/json,Authorization,Accept-Language-en)</br>
				Note user_type(1 -Normal User , 2- business User) </br> 
				Business Key(business_name,business_address,pos_system) </br>  
                first_name,last_name,email,phone_number,country_code,password,lat,log,device_type,device_token,user_type(1,2)       
	              </p>
	        <p> <h5>Response Required: </h5>SUCCESS or FAILURE</p>
	        <p> <h5>Brief Description: </h5>device_type:android,iphone</p>
	        <p> <h5>requestKey: </h5>user_signup</p>
	        <p> <h5>Sample Response: </h5>
	            <pre>   
                {
            "status": "SUCCESS",
            "message": "User created successfully.",
            "requestKey": "api/user_signup",
            "user_signup": {
                "first_name": "Rajiv",
                "last_name": "kumar",
                "email": "rajiv22@gmail.com",
                "phone_number": "87438921133",
                "password": "123456",
                "lat": "28.535517",
                "log": "77.391029",
                "device_type": "android",
                "device_token": "sadasdsadasdasdasdasd",
                "country_code": "+91",
                "user_type": "Normal",
                "notification_status": "On",
                "token": "dngeek1614vTgj1nXa2A9UJs3",
                "user_id": "2"
            }
        }     
	            </pre>
	        </p>
	        <p> <h5>Test Status: </h5></p>
	        <p> <h5>Notes: </h5></p>
	    </div>

	</div>  
</div>    

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
    	$('.accordion-toggle').on('click', function(event){
    		event.preventDefault();
    		
    		// create accordion variables
    		var accordion = $(this);
    		var accordionContent = accordion.next('.accordion-content');
    		var accordionToggleIcon = $(this).children('.toggle-icon');

    		// toggle accordion link open class
		    accordion.toggleClass("open");
		    
		    // toggle accordion content
		    accordionContent.slideToggle(250);

		    // change plus/minus icon
		    if (accordion.hasClass("open")) {
		    	accordionToggleIcon.html("<i class='fa fa-minus-circle'></i>");
		    } else {
		    	accordionToggleIcon.html("<i class='fa fa-plus-circle'></i>");
		    }
    	});
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function () {
    	$('ul.nav a').each(function(){
    		if(location.href === this.href){
    			$(this).addClass('active');
    			$('ul.nav a').not(this).removeClass('active');
    			return false;
    		}
    	});
    });
    </script>
</body>
</html>
