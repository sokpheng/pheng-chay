
<body>	
	To whom it may concern,
	<br/>
	<br/>
	Below are message from visitor of Cambodroom Website:
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
		@if(isset($phone))
			<tr>
				<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold; ">Phone: </td>
				<td style="border: 1px solid #B7B7B7; padding: 10px;">{{ $phone }}</td>
			</tr>
		@endif

		@if(isset($email))

			<tr>
				<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;     background-color: #FDFAF6;">Email: </td>
				<td style="border: 1px solid #B7B7B7; padding: 10px; background-color: #FDFAF6;">{{ $email }}</td>
			</tr>

		@endif

		@if(isset($desc))

			<tr>
				<td style="border: 1px solid #B7B7B7; padding: 10px; width: 150px; font-weight: bold;">Message: </td>
				<td style="border: 1px solid #B7B7B7; padding: 10px;"><pre style="font-size: 14px;">{{ $desc }}</pre></td>
			</tr>

		@endif
	</table>

	<br/>
	<br/>
	<i>Sent from automatically alerted system,</i>
</body>