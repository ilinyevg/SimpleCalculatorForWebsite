<?php
get_header();
global $cs_node, $cs_sidebarLayout, $cs_xmlObject, $cs_node_id, $column_attributes, $cs_paged_id,$page_element_size;
?>
 
<script src="/wp-content/plugins/dd/jquery.dd.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/plugins/dd/dd.css" />

 <script language="javascript">
jQuery(function ($)  {
try {
$("body select").msDropDown();
} catch(e) {
alert(e.message);
}
});
</script>

<style>
.left {
    float: left;
    width: 60%;
}
.right {
    float: right;
    width: 40%;
}
.group:after {
    content:"";
    display: table;
    clear: both;
}
 
@media screen and (max-width: 480px) {
    .left, 
    .right {
        float: none;
        width: auto;
    }
}
</style>

<!-- Main Content Section -->
<div id="main-content">
    <!-- Main Section -->
    <div class="main-section">
<div class="container"> 
<div class="row"> 
    
<?php 

function getItemDetails($arrName) {
    $style = $_POST[$arrName][0]; 
    $W = $_POST[$arrName][1]; 
    $H = $_POST[$arrName][2]; 
    $QTY = $_POST[$arrName][3]; 
    return "<li>Style: $style  Width: $W ft.  Height: $H ft.  Quantity: $QTY </li>";
}

function contact_send_message($equals) {

    $contact_errors = false;

    $name = $_POST['yourname'];
    $email_address = $_POST['youremail'];
    $phone_num = $_POST['phone']; 

    $window1 = $_POST['window1'][0]; 

    $header = "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/html; charset=utf-8\n";
    $header .= "From: name@email.com";

    $message = "<p>Dear $name,</p>
<p>We appreciate that you have used the calculator on <a href='http://.com/'>our website</a>. You can see a rough estimate of the cost of your new windows below.</p>";

    $message .= "<p>Name: $name </p>";
    $message .= "<p>Email: $email_address </p>";
    $message .= "<p>Phone: $phone_num </p><ul>"; 
 
    $message .= getItemDetails('window1'); 
$message .= getItemDetails('window2'); 
$message .= getItemDetails('window3'); 
$message .= getItemDetails('window4'); 
$message .= getItemDetails('window5'); 
$message .= getItemDetails('window6');  
$message .= getItemDetails('door'); 	 
    $message .= "</ul><h4>Estimate price: $<b>$equals</b>.00</h4><img src='http://yourwebsite.com/wp-content/uploads/2015/11/header-logo-e1447361745152.png' alt='Smart Energy Solutions'>
<p>Our manager will contact you soon.</p> <p>Best regards,</p><p>Company name</p><p>Our contact phone: <b>(844) 9999999</b></p>"; 

    $subject = "Window Estimates";
   
    $to = "name@email.com";

    if( !wp_mail($to, $subject, $message, $header) ) {
        $contact_errors = true;
    }
    
if( !wp_mail($email_address, $subject, $message, $header) ) {
        $contact_errors = true;
    }


return $contact_errors;
}
function check_window_size($control_name)
{
	$W = $_POST[$control_name][1];
    	$H = $_POST[$control_name][2]; 
	
	if ($W * $H >= 50) 
	{
		return false;
	}
	else
	{
		return true;
	}
}

function check_data()
{ 
    return check_window_size('window1') 
		and check_window_size('window2') 
		and check_window_size('window3') 
		and check_window_size('window4')
		and check_window_size('window5')
		and check_window_size('window6') ;
}

function calculate_area($control_name)
{
	$W = $_POST[$control_name][1];
        $H = $_POST[$control_name][2];
	$QTY = $_POST[$control_name][3];
	
    	return $W * $H * $QTY;
}

if($_POST)
{   
	if(check_data())
	{
		$equals = calculate_area('window1') 
			+ calculate_area('window2')
			+ calculate_area('window3')
			+ calculate_area('window4')
			+ calculate_area('window5')
			+ calculate_area('window6') ; 
		
		if ($equals >= 40)
		{
			$equals = $equals * 34;
		}
		else
		{
			$equals = $equals * 27;
		}
		
		$door = $_POST['door'][1] * $_POST['door'][2];
		
		if ($door <= 42)
		{ 
			$equals = $equals + $door * 30;
			
			$sendresult = contact_send_message($equals);
			$message = "<p style='color: #295029; '> Price was successfully calculated. Please check your e-mail. Our manager will contact you within 24 hours.  </p>" ;
		}
		else
		{
			$message = "<p style='color: #8A0303; '> Your window sizes are unique. Please contact us for pricing details. Phone: (844) 787- 7888. Anyway, our manager will contact you within 24 hours.</p>";
		}
	}
	else
	{
		$message = "<p style='color: #8A0303;'> Your window sizes are unique. Please contact us for pricing details. Phone: (844) 787- 7888. Anyway, our manager will contact you within 24 hours. </p>";
		$equals = 0;
	} 
}
else
{
    	$equals = 0;
	$message = "";
}
?>

<p>For calculating estimate price of your new windows, please input all required information below. Select style of your windows and size of it. Because usually most windows in house are different, you can choose several window styles. </p> 
<form method="POST"  > 
<?php if ($message != '') { echo $message; } ?>
	
<div class="group">
    <div class="left">
         <h3>
		Windows Calculator
	</h3>
<div class="calc-element">
	<label class="lbl">Style:</label>
	<select name="window1[]" class="windowselection" >
		<option value="Awning" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Awning</option>
		<option value="Bay" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bay-window.png">Bay windows</option>
		<option value="Bow" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bow-window.png">Bow windows</option>
		<option value="Casement" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/casement.png">Casement</option> 
		<option value="Single" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/single-hung.png" selected="selected" >Single hung</option>
		<option value="Double" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/double-hang.png">Double hung</option>
		<option value="Garden" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/garden-window.png">Garden Window</option>
		<option value="Jalousie" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/jalousie.png">Jalousie</option>
		<option value="Radius" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/radius.png">Radius windows</option>
		<option value="Horizontal" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Horizontal Slider</option>
		<option value="Picture" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/picture.png">Picture windows</option>
		<option value="Skylight" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/skylight.png">Skylight</option>
		<option value="Custom" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Custom</option>
	</select>
	<label class="lbl">Width:</label><input name="window1[]" class="num-element" placeholder="ft" type="number" step="0.01" />   
	<label class="lbl">Height:</label><input name="window1[]" class="num-element" placeholder="ft" type="number" step="0.01" /> 
	<label class="lbl">Quantity:</label><input name="window1[]" class="num-element"  type="number" value="1" />  
</div><div class="calc-element"> 
	<label class="lbl">Style:</label>
	<select name="window2[]" class="windowselection" >
		<option value="Awning" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Awning</option>
		<option value="Bay" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bay-window.png">Bay windows</option>
		<option value="Bow" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bow-window.png">Bow windows</option>
		<option value="Casement" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/casement.png">Casement</option> 
		<option value="Single" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/single-hung.png" selected="selected" >Single hung</option>
		<option value="Double" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/double-hang.png">Double hung</option>
		<option value="Garden" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/garden-window.png">Garden Window</option>
		<option value="Jalousie" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/jalousie.png">Jalousie</option>
		<option value="Radius" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/radius.png">Radius windows</option>
		<option value="Horizontal" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Horizontal Slider</option>
		<option value="Picture" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/picture.png">Picture windows</option>
		<option value="Skylight" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/skylight.png">Skylight</option>
		<option value="Custom" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Custom</option>
	</select>
	<label class="lbl">Width:</label><input name="window2[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Height:</label><input name="window2[]" class="num-element" placeholder="ft" type="number" step="0.01" />   
	<label class="lbl">Quantity:</label><input name="window2[]" class="num-element"  type="number" value="1"  />  
	</div><div class="calc-element"> 
	<label class="lbl">Style:</label>
	<select name="window3[]" class="windowselection" >
		<option value="Awning" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Awning</option>
		<option value="Bay" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bay-window.png">Bay windows</option>
		<option value="Bow" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bow-window.png">Bow windows</option>
		<option value="Casement" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/casement.png">Casement</option> 
		<option value="Single" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/single-hung.png" selected="selected" >Single hung</option>
		<option value="Double" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/double-hang.png">Double hung</option>
		<option value="Garden" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/garden-window.png">Garden Window</option>
		<option value="Jalousie" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/jalousie.png">Jalousie</option>
		<option value="Radius" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/radius.png">Radius windows</option>
		<option value="Horizontal" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Horizontal Slider</option>
		<option value="Picture" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/picture.png">Picture windows</option>
		<option value="Skylight" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/skylight.png">Skylight</option>
		<option value="Custom" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Custom</option>
	</select>
	<label class="lbl">Width:</label><input name="window3[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Height:</label><input name="window3[]" class="num-element" placeholder="ft" type="number" step="0.01" />   
	<label class="lbl">Quantity:</label><input name="window3[]" class="num-element"  type="number" value="1"  />  
	</div><div class="calc-element"> 
	<label class="lbl">Style:</label>
	<select name="window4[]" class="windowselection" >
		<option value="Awning" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Awning</option>
		<option value="Bay" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bay-window.png">Bay windows</option>
		<option value="Bow" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bow-window.png">Bow windows</option>
		<option value="Casement" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/casement.png">Casement</option> 
		<option value="Single" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/single-hung.png" selected="selected" >Single hung</option>
		<option value="Double" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/double-hang.png">Double hung</option>
		<option value="Garden" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/garden-window.png">Garden Window</option>
		<option value="Jalousie" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/jalousie.png">Jalousie</option>
		<option value="Radius" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/radius.png">Radius windows</option>
		<option value="Horizontal" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Horizontal Slider</option>
		<option value="Picture" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/picture.png">Picture windows</option>
		<option value="Skylight" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/skylight.png">Skylight</option>
		<option value="Custom" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Custom</option>
	</select>
	<label class="lbl">Width:</label><input name="window4[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Height:</label><input name="window4[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Quantity:</label><input name="window4[]" class="num-element"  type="number" value="1"  />  
	</div><div class="calc-element"> 
	<label class="lbl">Style:</label>
	<select name="window5[]" class="windowselection" >
		<option value="Awning" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Awning</option>
		<option value="Bay" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bay-window.png">Bay windows</option>
		<option value="Bow" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bow-window.png">Bow windows</option>
		<option value="Casement" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/casement.png">Casement</option> 
		<option value="Single" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/single-hung.png" selected="selected" >Single hung</option>
		<option value="Double" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/double-hang.png">Double hung</option>
		<option value="Garden" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/garden-window.png">Garden Window</option>
		<option value="Jalousie" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/jalousie.png">Jalousie</option>
		<option value="Radius" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/radius.png">Radius windows</option>
		<option value="Horizontal" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Horizontal Slider</option>
		<option value="Picture" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/picture.png">Picture windows</option>
		<option value="Skylight" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/skylight.png">Skylight</option>
		<option value="Custom" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Custom</option>
	</select>
	<label class="lbl">Width:</label><input name="window5[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Height:</label><input name="window5[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Quantity:</label><input name="window5[]" class="num-element"  type="number" value="1"  />  
	</div><div class="calc-element"> 
	<label class="lbl">Style:</label>
	<select name="window6[]" class="windowselection"  >
		<option value="Awning" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Awning</option>
		<option value="Bay" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bay-window.png">Bay windows</option>
		<option value="Bow" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/bow-window.png">Bow windows</option>
		<option value="Casement" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/casement.png">Casement</option> 
		<option value="Single" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/single-hung.png" selected="selected" >Single hung</option>
		<option value="Double" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/double-hang.png">Double hung</option>
		<option value="Garden" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/garden-window.png">Garden Window</option>
		<option value="Jalousie" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/jalousie.png">Jalousie</option>
		<option value="Radius" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/radius.png">Radius windows</option>
		<option value="Horizontal" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Horizontal Slider</option>
		<option value="Picture" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/picture.png">Picture windows</option>
		<option value="Skylight" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/skylight.png">Skylight</option>
		<option value="Custom" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Awning.png">Custom</option>
	</select>
	<label class="lbl">Width:</label><input name="window6[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Height:</label><input name="window6[]" class="num-element" placeholder="ft" type="number" step="0.01" />  
	<label class="lbl">Quantity:</label><input name="window6[]" class="num-element"  type="number" value="1"  />  
	</div><div class="calc-element"> 
	<h3>
	Patio door
	</h3>
<label class="lbl">Style:</label>
	<select name="door[]" class="doorselection" >
		<option value="Sliding" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Sliding.png">Sliding Patio Doors</option> 
		<option value="French" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Sliding.png">French-Style Sliding</option> 
		<option value="In-Swing" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Swing.png">In-Swing French</option> 
		<option value="Out-Swing" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/Swing.png">Out-Swing French</option> 
		<option value="Pocket-Glass" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/glass-wall.png">Pocket Glass Wall</option> 
		<option value="Bi-Fold-Glass" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/glass-wall.png">Bi-Fold Glass Wall</option> 
		<option value="Stacking-Glass" data-image="http://yourwebsite.com/wp-content/uploads/2015/11/stacking.png">Stacking Glass Wall</option> 
	</select>
	<label class="lbl">Width:</label><input name="door[]" class="num-element" placeholder="ft" type="number" step="0.01" />   
	<label class="lbl">Height:</label><input name="door[]" class="num-element" placeholder="ft" type="number" step="0.01" /> 
</div>

    </div>
    <div class="right">
        <h3>
		GET PRICE!
	</h3>
<div class="calc-element">
<label class="lbl" style="width: 100px;">Your name:</label><input class="textinput" name="yourname" type="text" required />  
</div>
<div class="calc-element">
<label class="lbl" style="width: 100px;">Your phone:</label><input class="textinput" name="phone" type="tel" required  />  
</div>
<div class="calc-element">
<label class="lbl" >Your email:</label><input class="textinput" type="email" name="youremail" required/>  
</div> <div>
	<button type="submit" class="quick-btn cs-bgcolor">
		SEND ME ESTIMATE
	</button></div>
	
    </div>
</div>
 
	</form> 
<div>
         </div>    
    </div>
    </div>
 </div>
<?php get_footer(); ?>
