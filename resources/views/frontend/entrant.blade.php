<html>

	<head>
		<meta charset="UTF-8">
		@include('social::meta-article', [
			'title'         => $entrant->first_name . '\'s One in a Million Entry',
			'description'   => $entrant->contest->message,
			'image'         => $entrant->shareImage->url(),
			'author'        => $entrant->station->name
		])
		<title>{{  $entrant->first_name }}'s One in a Million Entry</title>
	</head>
	<body>
		<div style="text-align:center">
			<img style="max-width:100%" src="{{ $entrant->shareImage->url() }}" />
		</div>
	</body>
</html>