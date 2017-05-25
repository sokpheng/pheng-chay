
<body>	
	To whom it may concern,
	<br/>
	<br/>
	Below are message from visitor of Biz-Demension Website:
	<br/>
	<br/>
	Message:
	<br/>
	<br/>
	<table style="border: 1px solid #B7B7B7; border-collapse: collapse; width: 100%">
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;background-color: #FDFAF6;">Name: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #FDFAF6;">{{ $name }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold; ">Email: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px;">{{ $email }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold; ">Contact No: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px;">{{ $contact_no }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold; ">Company Name: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px;">{{ $company_name }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;background-color: #FDFAF6;">Message: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #FDFAF6;">{{ $desc }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;background-color: #FDFAF6;">Product Link: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #FDFAF6;">{{ isset($link) ? URL::to('/') . '/' . $link : '' }}</td>
		</tr>
	</table>

	<br/>
	<br/>
	<i>Sent from automatically alerted system,</i>
</body>