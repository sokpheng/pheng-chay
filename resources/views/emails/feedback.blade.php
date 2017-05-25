
<body>	
	To whom it may concern,
	<br/>
	<br/>
	Below are message from visitor of Camboroom Website:
	<br/>
	<br/>
	Message:
	<br/>
	<br/>
	<table style="border: 1px solid #B7B7B7; border-collapse: collapse; width: 100%">
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;     background-color: #FDFAF6;">Name: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #FDFAF6;">{{ $name }}</td>
		</tr>
		@if(isset($feeling))
			<tr>
				<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold; ">Feeling: </td>
				<td style="border: 1px solid #B7B7B7; padding: 10px;">{{ $feeling }}</td>
			</tr>
		@endif
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;     background-color: #FDFAF6;">Email: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #FDFAF6;">{{ $email }}</td>
		</tr>
		<tr>
			<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;">Message: </td>
			<td style="border: 1px solid #B7B7B7; padding: 10px;"><pre style="font-size: 14px;">{{ $desc }}</pre></td>
		</tr>
	</table>

	<br/>
	<br/>
	<i>Sent from automatically alerted system,</i>
</body>