
<body style="    background-color: #E8E7E6;font-family: sans-serif;">	
   	<div style="    max-width: 600px;
    margin: 0px auto;
    padding-bottom: 30px;
    background-color: white;
    margin-top: 50px;
    border-top: 10px solid #619c7f;
    box-shadow: 1px 1px 1px 1px #D4D4D4;">

	    <div class="" style="text-align: center;
    padding: 30px;
    border-bottom: 1px solid #DEDEDE;
    margin-bottom: 20px;">
	    	<img class="logo revel_animate" src="https://www.flexitech.io:1088/img/biz-dimension-logo.png" alt="biz-dimension logo" data-sr-id="2" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 1s cubic-bezier( 0.6, 0.2, 0.1, 1 ) 0s, opacity 1s cubic-bezier( 0.6, 0.2, 0.1, 1 ) 0s; transition: transform 1s cubic-bezier( 0.6, 0.2, 0.1, 1 ) 0s, opacity 1s cubic-bezier( 0.6, 0.2, 0.1, 1 ) 0s;  width: 200px">
	    </div>
	    <div style="padding: 15px; border-bottom: 1px solid #F3F3F3;
    padding-bottom: 30px; ">
	    	<div style="font-weight: 600; font-size: 14px;">
				Dear {{ $name }},
				<br/>
				<br/>
				We are grateful for your interests and having contacted us through our website contact form.
				Our team will got notified and be in your service shortly. 
				<br/>
				<br/>
				We love to help and hear from you!
			</div>
		</div>
		<div style="padding: 15px;">
			<br/>

			Your Message:
			<br/>
			<br/>
			<table style="border: 1px solid #B7B7B7; border-collapse: collapse; width: 100%; font-size: 13px;">
				<tr>
					<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;     background-color: #EAEAEA">Name: </td>
					<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #EAEAEA;">{{ $name }}</td>
				</tr>
				@if(isset($phone))
					<tr>
						<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold; ">Phone: </td>
						<td style="border: 1px solid #B7B7B7; padding: 10px;">{{ $phone }}</td>
					</tr>
				@endif
				<tr>
					<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;     background-color: #EAEAEA;">Email: </td>
					<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #EAEAEA;">{{ $email }}</td>
				</tr>
				<tr>
					<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;">Message: </td>
					<td style="border: 1px solid #B7B7B7; padding: 10px;"><pre style="font-size: 14px;">{{ $desc }}</pre></td>
				</tr>
			</table>
		</div>
		<br/>
		<br/>
		<i style="display: inline-block; padding: 15px;  font-size: 11px;">Sent from automatically alerted system,</i>
	</div>
</body>