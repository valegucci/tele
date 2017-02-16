<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/prism.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>
  <body>


<div class="container">
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<h1>Get Vendors</h1>
			<p>GET telematics vendors</p>
			<h3>Endpoint</h3>
			<div class="well well-sm">http://californiaest.com/r4me-telematics/api/vendors.php</div>
			<h3>Parameters</h3>
	<table class="table">
  <thead>
    <tr>
      <th style="text-align: left">Parameter</th>
      <th style="text-align: left">Type</th>
      <th style="text-align: left">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="text-align: left">api_key</td>
      <td style="text-align: left">string</td>
      <td style="text-align: left">API KEY of the user</td>
    </tr>
    <tr>
      <td style="text-align: left">size</td>
      <td style="text-align: left">string</td>
      <td style="text-align: left">Filter vendors by size. Accepted values: global, regional, local. </td>
    </tr>
    <tr>
      <td style="text-align: left">is_integrated</td>
      <td style="text-align: left">integer</td>
      <td style="text-align: left">Filter vendors by integration with Route4Me. accepted values: 0 and 1</td>
    </tr>
    <tr>
      <td style="text-align: left">feature</td>
      <td style="text-align: left">string</td>
      <td style="text-align: left">filter vendors by a feature slug</td>
    </tr>
    <tr>
      <td style="text-align: left">country</td>
      <td style="text-align: left">string</td>
      <td style="text-align: left">filter vendors by a country code. <a href="https://github.com/raramuridesign/mysql-country-list/blob/master/mysql-country-list.sql" target="_blank">Here</a> are the country codes</td>
    </tr>
    <tr>
      <td style="text-align: left">search</td>
      <td style="text-align: left">string</td>
      <td style="text-align: left">search vendors</td>
    </tr>
    <tr>
      <td style="text-align: left">page</td>
      <td style="text-align: left">integer</td>
      <td style="text-align: left">Filter vendors by page</td>
    </tr>
    <tr>
      <td style="text-align: left">per_page</td>
      <td style="text-align: left">integer</td>
      <td style="text-align: left">Choose how many vendors to display per page.</td>
    </tr>
  </tbody>
</table>
		</div>
		<div class="col-sm-6 col-xs-12">
			<h2>Example response</h2>
<pre><code>
{
  "vendors": [
    {
      "id": "56",
      "name": "4gFlota",
      "slug": "4gflota",
      "logo_url": "http:\/\/localhost:8080\/telematics\/logos\/4gflota589c17b842c3f4.62618649.png",
      "website_url": "",
      "api_docs_url": "",
      "is_integrated": "1",
      "size": "global"
    },
    {
      "id": "55",
      "name": "Quartix",
      "slug": "quartix",
      "logo_url": "http:\/\/localhost:8080\/telematics\/logos\/quartix589973f56b53c7.45431204.png",
      "website_url": "https:\/\/www.quartix.net",
      "api_docs_url": "",
      "is_integrated": "0",
      "size": "global"
    },
    {
      "id": "37",
      "name": "Gurtam",
      "slug": "gurtam",
      "logo_url": "http:\/\/localhost:8080\/telematics\/logos\/gurtam.png",
      "website_url": "https:\/\/gurtam.com\/",
      "api_docs_url": "",
      "is_integrated": "1",
      "size": "global"
    }
  ]
}
</code></pre>
<h2>Errors</h2>
<pre><code>
{
	"errors":[
	"Incorrect API key",
	"API key not defined",
	"Incorrect Size",
	"Incorrect is_integrated value",
	"There is no such feature",
	"There is no such country"
	]
}
</code></pre>
		</div>
	</div>
</div>

<hr/>

<div class="container" style="margin-top:24px">
	<div class="row">
		<div class="col-sm-6 col-xs-12">
<h1>Get a Vendor</h1>
			<p>GET a telematics vendor</p>
			<h3>Endpoint</h3>
			<div class="well well-sm">http://californiaest.com/r4me-telematics/api/vendors.php</div>
			<h3>Parameters</h3>
	<table class="table">
  <thead>
    <tr>
      <th style="text-align: left">Parameter</th>
      <th style="text-align: left">Type</th>
      <th style="text-align: left">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="text-align: left">api_key</td>
      <td style="text-align: left">string</td>
      <td style="text-align: left">API KEY of the user</td>
    </tr>
    <tr>
      <td style="text-align: left">vendor_id</td>
      <td style="text-align: left">integer</td>
      <td style="text-align: left">Vendor ID</td>
    </tr>
   </tbody>
</table>
		</div>
		<div class="col-sm-6 col-xs-12">
			<h2>Example response</h2>
<pre><code>
{
  "vendor": {
    "id": "57",
    "name": "Beame",
    "slug": "beame",
    "description": "Beame is the smallest, wireless stolen vehicle tracking device on the market, backed by a dedicated recovery team that will find your wheels whenever, wherever.",
    "logo_url": "http://localhost:8080/telematics/logos/beame58a41a55987d15.76453857.png",
    "website_url": "https://www.beam-e.com/",
    "api_docs_url": "",
    "is_integrated": "1",
    "size": "global",
    "features": [
      {
        "id": "121",
        "name": "Customizable Reports",
        "slug": "customizable-reports",
        "group": "Analytics & Reporting"
      },
      {
        "id": "123",
        "name": "Modern Software Development Kits (SDKs)",
        "slug": "modern-sdks",
        "group": "API & SDK"
      }
    ],
    "countries": [
      {
        "id": "5",
        "code": "AD",
        "name": "Andorra"
      }
    ]
  }
}
</code></pre>

<h2>Errors</h2>
<pre><code>
{
	"errors":[
		"Incorrect API key",
		"API key not defined",
		"Incorrect vendor ID"
	]
}
</code></pre>
		</div>
	</div>
</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  	<script src="assets/prism.js"></script>
  </body>
</html>