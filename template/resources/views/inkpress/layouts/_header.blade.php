<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<title>@if(isset($page_title)){{ $page_title .' - '. dujiaoka_config_get('title') }}@else{{ dujiaoka_config_get('title') }}@endif</title>
<meta name="keywords" content="{{ dujiaoka_config_get('keywords') }}">
<meta name="description" content="{{ dujiaoka_config_get('description') }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="/favicon.ico">
