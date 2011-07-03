<?php

require_once "arc2/ARC2.php";
require_once "Graphite/graphite/Graphite.php";

$ns = array(
	"geonames" => "http://www.geonames.org/ontology#",
	"geo" => "http://www.w3.org/2003/01/geo/wgs84_pos#",
	"foaf" => "http://xmlns.com/foaf/0.1/",
	"om" => "http://www.opengis.net/om/1.0/",
	"om2" => "http://rdf.channelcoast.org/ontology/om_tmp.owl#",
	"gml" => "http://www.opengis.net/gml#",
	"xsi" => "http://schemas.opengis.net/om/1.0.0/om.xsd#",
	"rdf" => "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
	"rdfs" => "http://www.w3.org/2000/01/rdf-schema#",
	"owl" => "http://www.w3.org/2002/07/owl#",
	"pv" => "http://purl.org/net/provenance/ns#",
	"xsd" => "http://www.w3.org/2001/XMLSchema#",
	"dc" => "http://purl.org/dc/elements/1.1/",
	"lgdo" => "http://linkedgeodata.org/ontology/",
	"georss" => "http://www.georss.org/georss/",
	"eurostat" => "http://www4.wiwiss.fu-berlin.de/eurostat/resource/eurostat/",
	"postcode" => "http://data.ordnancesurvey.co.uk/ontology/postcode/",
	"admingeo" => "http://data.ordnancesurvey.co.uk/ontology/admingeo/",
	"skos" => "http://www.w3.org/2004/02/skos/core#",
	"dbpedia-owl" => "http://dbpedia.org/ontology/",
	"ssn" => "http://purl.oclc.org/NET/ssnx/ssn#",
	"ssne" => "http://www.semsorgrid4env.eu/ontologies/SsnExtension.owl#",
	"DUL" => "http://www.loa-cnr.it/ontologies/DUL.owl#",
	"time" => "http://www.w3.org/2006/time#",
	"sw" => "http://sweet.jpl.nasa.gov/2.1/sweetAll.owl#",
	"id-semsorgrid" => "http://id.semsorgrid.ecs.soton.ac.uk/",
	"sciUnits" => "http://sweet.jpl.nasa.gov/2.0/sciUnits.owl#",
	"dctypes" => "http://purl.org/dc/dcmitype/",
	"po" => "http://purl.org/ontology/po/",
	"wo" => "http://purl.org/ontology/wo/",
	"bbc" => "http://www.bbc.co.uk/",
);

define("ENDPOINT_LINKEDGEODATA", "http://linkedgeodata.org/sparql/");

$cachedir = "/tmp/mashupcache/graphite";

$graph = new Graphite($ns);
if (!is_dir($cachedir))
	mkdir($cachedir);
$graph->cacheDir($cachedir);

$graph->load("http://www.bbc.co.uk/nature/life/Bird");
$graph->load("wo:");

foreach ($graph->allOfType("wo:Order") as $order)
	$order->load();
foreach ($graph->allOfType("wo:Family") as $family)
	$family->load();
foreach ($graph->allOfType("wo:Genus") as $genus)
	$genus->load();
foreach ($graph->allOfType("wo:Species") as $species)
	$species->load();

foreach ($graph->allOfType("owl:Class") as $class) {
	if ($class->isType("wo:Habitat"))
		echo $graph->shrinkURI($habitat) . " -- " . $habitat->label() . "<br>\n";
}

$whitelist = array(
	//"resident" => array(
		//"wader" => array(
			$graph->resource("bbc:nature/life/Northern_Lapwing#species"),
			//Redshank: can't find
			$graph->resource("bbc:nature/life/Eurasian_Oystercatcher#species"),
			$graph->resource("bbc:nature/life/Little_Ringed_Plover#species"),
		//),
		//"wildfowl" => array(
			$graph->resource("bbc:nature/life/Mallard#species"),
			//Shelduck: can't find
			//Gadwall: can't find
			//Shoveler: can't find
		//),
		//"other" => array(
			$graph->resource("bbc:nature/life/Skylark#species"),
			//Meadow pipit: can't find
			$graph->resource("bbc:nature/life/Reed_Bunting#species"),
			$graph->resource("bbc:nature/life/Bearded_Reedling#species"),
		//),
	//),
	//"passage/wintering" => array(
		//"waders" => array(
			//Black tailed godwit: can't find
			//Grey Plover: can't find
			$graph->resource("bbc:nature/life/Red_Knot#species"),
		//),
		//"wildfowl" => array(
			//Wigeon: can't find
			//Teal: can't find
			//Pintail: can't find
			$graph->resource("bbc:nature/life/Brant_Goose#species"),
		//),
	//),
	//"summer" => array(
		//"other" => array(
			$graph->resource("bbc:nature/life/Eurasian_Reed_Warbler#species"),
			$graph->resource("bbc:nature/life/Sedge_Warbler#species"),
			//Whitethroat warbler: can't find
			$graph->resource("bbc:nature/life/Common_Swift#species"),
			$graph->resource("bbc:nature/life/Sand_Martin#species"),
			$graph->resource("bbc:nature/life/Barn_Swallow#species"),
		//)
	//),
	//"occasional" => array(
		//"other" => array(
			//Curlew Sandpiper: can't find
			//Spotted crake: can't find
			//Wryneck: can't find
			$graph->resource("bbc:nature/life/Whooper_Swan#species"),
			//Whitefronted geese (winter): can't find
			$graph->resource("bbc:nature/life/Eurasian_Bittern#species"),
			$graph->resource("bbc:nature/life/Osprey#species"),
			$graph->resource("bbc:nature/life/Short-eared_Owl#species"),
		//),
	//),
);

$habitats = array(
	"marsh" => $graph->resource("bbc:nature/habitats/Marsh#habitat"),
	"coast" => $graph->resource("bbc:nature/habitats/Coast#habitat"),
	"estuary" => $graph->resource("bbc:nature/habitats/Estuary#habitat"),
	"intertidal_zone" => $graph->resource("bbc:nature/habitats/Intertidal_zone#habitat"),
	"lake" => $graph->resource("bbc:nature/habitats/Lake#habitat"),
	"river" => $graph->resource("bbc:nature/habitats/River#habitat"),
	"wetland" => $graph->resource("bbc:nature/habitats/Wetland#habitat"),
	"flooded_grasslands_and_savannas" => $graph->resource("bbc:nature/habitats/Flooded_grasslands_and_savannas#habitat"),
	"swamp" => $graph->resource("bbc:nature/habitats/Swamp#habitat"),
	"bog" => $graph->resource("bbc:nature/habitats/Bog#habitat"),
);

foreach ($habitats as $habitat)
	$habitat->load();

function getbirds($habitats) {
	global $graph;

	if (!is_array($habitats))
		$habitats = array($habitats);

	$birds = array();
	foreach ($habitats as $habitat) {
		foreach ($graph->allOfType("wo:Species") as $species) {
			foreach ($species->all("wo:livesIn") as $livesin) {
				if ($livesin->uri == $habitat->uri) {
					$birds[] = $species;
					break;
				}
			}
		}
	}

	$birds = new Graphite_ResourceList($graph, $birds);
	$birds = $birds->distinct();
	return $birds;
}

// load tide sensor linked data
$triples = $graph->load("http://id.semsorgrid.ecs.soton.ac.uk/observations/cco/lymington_tide/TideHeight/latest");
if ($triples < 1)
	die("failed to load any triples from '$tideobservationsURI'");

// get tide sensor URI
$sensor = $graph->allOfType("ssn:Observation")->get("ssn:observedBy")->distinct()->current();
if ($sensor->isNull())
	die("no observations");
$sensorURI = $sensor->uri;

// get sensor coordinates
if ($graph->load($sensorURI) == 0)
	die("couldn't load sensor RDF");
$location = $graph->resource($sensorURI)->get("ssn:hasDeployment")->get("ssn:deployedOnPlatform")->get("sw:hasLocation");
if ($location->isNull())
	die("couldn't get sensor coordinates");
$coords = array(
	floatVal((string) $location->get("sw:coordinate2")->get("sw:hasNumericValue")),
	floatVal((string) $location->get("sw:coordinate1")->get("sw:hasNumericValue")),
);

// collect times and heights
$tideobservations = array();
foreach ($graph->allOfType("ssn:Observation") as $observationNode) {
	if ($observationNode->get("ssn:observedProperty") != "http://www.semsorgrid4env.eu/ontologies/CoastalDefences.owl#TideHeight")
		continue;
	$timeNode = $observationNode->get("ssn:observationResultTime");
	if (!$timeNode->isType("time:Interval"))
		continue;
	$tideobservations[] = array(strtotime($timeNode->get("time:hasBeginning")),
		floatVal((string) $observationNode->get("ssn:observationResult")->get("ssn:hasValue")->get("ssne:hasQuantityValue")));
}

// sort in ascending date order
usort($tideobservations, "sortreadings");
function sortreadings($a, $b) {
	return $a[0] - $b[0];
}

// get predicted tide height
$predicted = array();
$offset = null;//TODO: remove!
foreach (file("http://apps.semsorgrid.ecs.soton.ac.uk/tide/") as $line) {
	list($time, $height) = explode("\t", $line);
	if (is_null($offset))
		$offset = $time - strtotime("2011-02-15");//TODO: remove!
	$predicted[] = array(($time - $offset), trim($height));//TODO: remove offset!
}

// current time
$now = strtotime("2011-02-15 11:45"); //TODO: replace this with current time

// current height
$currentheight = $tideobservations[count($tideobservations) - 1];
$currentheight = $currentheight[1];

// get birds which might be around in current conditions
$highthreshold = 4.23;
$lowthreshold = 1.21;

$wetlandbirds = getbirds($habitats["wetland"]);
$marshbirds = getbirds($habitats["marsh"]);
$swampbirds = getbirds($habitats["swamp"]);
$bogbirds = getbirds($habitats["bog"]);

$lowbirds = $wetlandbirds->intersection($whitelist);
$midbirds = $marshbirds->intersection($whitelist);
$highbirds = $marshbirds->union($swampbirds)->union($bogbirds)->intersection($whitelist);

$allbirds = $lowbirds->union($midbirds)->union($highbirds);
$alwaysbirds = $lowbirds->intersection($midbirds)->intersection($highbirds);

if ($currentheight < $lowthreshold) {
	$currentlevel = "low";
	$currentbirds = $lowbirds;
	$higherbirds = $midbirds->union($highbirds)->except($currentbirds);
	$lowerbirds = null;
} else if ($currentheight < $highthreshold) {
	$currentlevel = "mid";
	$currentbirds = $midbirds;
	$higherbirds = $highbirds->except($currentbirds);
	$lowerbirds = $lowbirds->except($currentbirds);
} else {
	$currentlevel = "high";
	$currentbirds = $highbirds;
	$higherbirds = null;
	$lowerbirds = $lowbirds->union($midbirds)->except($currentbirds);
}

$types_pub = array(
	"lgdo:Pub",
	"lgdo:Bar",
);
$types_cafe = array(
	"lgdo:CoffeeShop",
	"lgdo:Cafe",
	"lgdo:InternetCafe",
);
$types_food = array(
	"lgdo:Restaurant",
	"lgdo:FastFood",
	"lgdo:Barbeque",
	"lgdo:IceCream",
);
$types_store = array(
	"lgdo:Shops",
	"lgdo:Shop",
	"lgdo:Shopping",
	"lgdo:Supermarket",
	"lgdo:Bakery",
	"lgdo:Marketplace",
	"lgdo:PublicMarket",
	"lgdo:TakeAway",
	"lgdo:DrinkingWater",
	"lgdo:WaterFountain",
	"lgdo:WaterWell",
);
$types_parking = array(
	"lgdo:Parking",
	"lgdo:MotorcycleParking",
	"lgdo:BicycleParking",
);
$pubbar = nearbyamenities($types_pub, $coords, 3);
$cafe = nearbyamenities($types_cafe, $coords, 3);
$restaurant = nearbyamenities($types_food, $coords, 3);
$shop = nearbyamenities($types_store, $coords, 3);
$parking = nearbyamenities($types_parking, $coords, 3);
function amenitylist($amenities) {
	global $coords;
	if (is_null($amenities) || count($amenities) == 0) { ?>
		<p>Nothing found nearby</p>
		<?php
		return;
	}
	?>
	<ul>
		<?php foreach ($amenities as $uri => $amenity) { ?>
			<li>
				<?php echo htmlspecialchars($amenity[0]); ?>
				<span class="hint">(<?php echo sprintf("%.01f", distance($coords, $amenity[1])); ?>km)</span>
				<a class="uri" href="<?php echo htmlspecialchars($uri); ?>"></a>
			</li>
		<?php } ?>
	</ul>
	<?php
}
// query linkedgeodata.org for nearby amenities
function nearbyamenities($type, $latlon, $radius = 10) {
	global $ns;

	// upgrade $type to an array of itself if an array wasn't given
	if (!is_array($type))
		$type = array($type);

	// execute query
	$rows = sparqlquery(ENDPOINT_LINKEDGEODATA, "
		SELECT *
		WHERE {
			{ ?place a " . implode(" . } UNION { ?place a ", $type) . " . }
			?place
				a ?type ;
				geo:geometry ?placegeo ;
				rdfs:label ?placename .
			FILTER(<bif:st_intersects> (?placegeo, <bif:st_point> ($latlon[1], $latlon[0]), $radius)) .
		}
	");

	// collect results
	$results = array();
	foreach ($rows as $row) {
		$coords = parsepointstring($row['placegeo']);
		$results[$row["place"]] = array($row['placename'], $coords, distance($coords, $latlon));
	}

	// sort according to ascending distance from centre
	uasort($results, "sortbythirdelement");

	return $results;
}
function sortbythirdelement($a, $b) {
	$diff = $a[2] - $b[2];
	// usort needs integers, floats aren't good enough
	return $diff < 0 ? -1 : ($diff > 0 ? 1 : 0);
}

// return results of a Sparql query
// maxage is the number of seconds old an acceptable cached result can be 
// (default one day, 0 means it must be collected newly. false means must be 
// collected newly and the result will not be stored. true means use cached 
// result however old it is)
// type is passed straight through to Arc
// missing prefixes are added
function sparqlquery($endpoint, $query, $type = "rows", $maxage = 86400/*1 day*/) {
	$cachedir = "/tmp/mashupcache/sparql/" . md5($endpoint);

	if (!is_dir($cachedir))
		mkdir($cachedir) or die("couldn't make cache directory");

	$query = addmissingprefixes($query);

	$cachefile = $cachedir . "/" . md5($query . $type);

	// collect from cache if available and recent enough
	if ($maxage === true && file_exists($cachefile) || $maxage !== false && $maxage > 0 && file_exists($cachefile) && time() < filemtime($cachefile) + $maxage)
		return unserialize(file_get_contents($cachefile));

	// cache is not to be used or cached file is out of date. query endpoint
	$config = array(
		"remote_store_endpoint" => $endpoint,
		"reader_timeout" => 120,
		"ns" => $GLOBALS["ns"],
	);
	$store = ARC2::getRemoteStore($config);
	$result = $store->query($query, $type);
	if (!empty($store->errors)) {
		foreach ($store->errors as $error)
			trigger_error("Sparql error: " . $error, E_USER_WARNING);
		return null;
	}

	// store result unless caching is switched off
	if ($maxage !== false)
		file_put_contents($cachefile, serialize($result));

	return $result;
}

// return a Sparql PREFIX string, given a namespace key from the global $ns 
// array, or many such PREFIX strings for an array of such keys
function prefix($n = null) {
	global $ns;
	if (is_null($n))
		$n = array_keys($ns);
	if (!is_array($n))
		$n = array($n);
	$ret = "";
	foreach ($n as $s)
		$ret .= "PREFIX $s: <" . $ns[$s] . ">\n";
	return $ret;
}

// parse a string
// 	POINT(longitude latitude)
// and return
// 	array(float latitude, float longitude)
function parsepointstring($string) {
	$coords = array_map("floatVal", explode(" ", preg_replace('%^.*\((.*)\)$%', '\1', $string)));
	return array_reverse($coords);
}

// return the distance in km between two array(lat, lon)
function distance($latlon1, $latlon2) {
	$angle = acos(sin(deg2rad($latlon1[0])) * sin(deg2rad($latlon2[0])) + cos(deg2rad($latlon1[0])) * cos(deg2rad($latlon2[0])) * cos(deg2rad($latlon1[1] - $latlon2[1])));
	$earthradius_km = 6372.8;
	return $earthradius_km * $angle;
}

// add missing PREFIX declarations to a Sparql query
function addmissingprefixes($query) {
	global $ns;

	// find existing prefix lines
	preg_match_all('%^\s*PREFIX\s+(.*?):\s*<.*>\s*$%m', $query, $matches);
	$existing = $matches[1];

	// get query without prefix declarations
	$queryonly = $query;
	if (count($existing)) {
		if (strpos($query, "\nPREFIX") !== false)
			$queryonly = substr($query, strlen($query) - strpos(strrev($query), strrev("\nPREFIX")));
		$queryonly = preg_replace('%^[^\n]*\n%', "", $queryonly);
	}

	// find namespaces used in query
	preg_match_all('%(?:^|[\s,;])([^\s:<]*):%m', $queryonly, $matches);
	$used = array_unique($matches[1]);

	// list of namespaces to add
	$add = array();
	foreach ($used as $short) {
		if (in_array($short, $existing))
			continue;
		if (!in_array($short, array_keys($ns)))
			trigger_error("Namespace '$short' used in Sparql query not found in global namespaces array", E_USER_WARNING);
		else
			$add[] = $short;
	}

	$query = prefix($add) . $query;
	return $query;
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Birdwatching mashup</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="flot/jquery.flot.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.1.pack.js"></script>
	<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.1.css" media="screen" type="text/css">
	<script type="text/javascript">
		$(document).ready(function() {
			// slidey definition lists
			expandcollapsedl = function(e) {
				e.preventDefault();
				if ($(this).parents("dt:first").next("dd:first").is(":visible")) {
					$(this).removeClass("collapselink").addClass("expandlink");
					$(this).parents("dt:first").next("dd:first").slideUp("fast");
				} else {
					$(this).parents("dl:first").find(".collapselink").removeClass("collapselink").addClass("expandlink");
					$(this).removeClass("expandlink").addClass("collapselink");
					$(this).parents("dl:first").children("dd").not($(this).parents("dt:first").next("dd:first")).slideUp("fast");
					$(this).parents("dt:first").next("dd:first").slideDown("fast");
				}
			};
			$("dl.single > dd").hide();
			$("dl.single > dt:first-child + dd").show();
			$("dl.single > dt").each(function() {
				$(this).html("<a class=\"expandlink\" href=\"#\">" + $(this).html() + "</a>");
			});
			$("dl.single > dt:first-child .expandlink").removeClass("expandlink").addClass("collapselink");
			$("dl.single > dt a.expandlink, dl.single > dt a.collapselink").click(expandcollapsedl);

			// fancyboxes
			$("a.fancybox").fancybox();
		});
	</script>
	<style type="text/css">
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
		body {
			background-color: #222;
			color: #ccc;
			font-family: sans-serif;
			font-size: 10pt;
		}
		body .hidden {
			display: none;
		}
		.contentarea {
			background-color: #333;
			margin: 0.5em;
			padding: 0.5em;
		}
		#birdlist {
		}
		#birdinfo {
			width: 70%;
			height: 60%;
		}
		#graph {
			width: 760px;
			height: 280px;
			margin: 0 auto;
		}
		#graph_legend table {
			margin: 0 auto;
			color: inherit !important;
		}
		#birdlist dl, #birdlist ul, #birdlist li, #birdlist dd {
			margin: 0;
			padding: 0;
		}
		#birdlist li {
			display: inline-block;
			margin: 0.5em;
			text-align: center;
		}
		#birdlist dd {
			margin-left: 1em;
		}
		.hint {
			text-shadow: 1px 1px 0px #000;
			color: #888;
			font-size: 90%;
		}
		h3 {
			font-size: 100%;
			margin: 0;
			padding: 0;
			font-weight: normal;
		}
		a.uri {
			padding-right: 24px;
			background-image: url(images/uri.png);
			background-repeat: no-repeat;
			background-position: center right;
		}
		dt {
			margin-top: 1em;
		}
		a {
			color: #aca;
			text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
			text-decoration: none;
		}
		a:hover {
			text-decoration: underline;
		}
		.expandlink, .collapselink {
			padding-left: 16px;
			background-repeat: no-repeat;
			background-position: center left;
		}
		.expandlink {
			background-image: url("images/bullet_toggle_plus.png");
		}
		.collapselink {
			background-image: url("images/bullet_toggle_minus.png");
		}
		h1 {
			text-align: center;
		}
		img {
			-moz-box-shadow: 3px 3px 15px -5px #000;
			border: 0;
		}
		#fancybox-outer {
			background-color: #111;
		}
	</style>
</head>
<body>
<h1>Birdwatching mashup</h1>
<div class="contentarea" id="graphpane">
	<h2>Tide height</h2>
	<div class="pad">
		<div id="graph"></div>
		<div id="graph_legend"></div>
		<script type="text/javascript">
			$(function() {
				<?php
				function timestamptomilliseconds($readings) {
					$a = array();
					foreach ($readings as $reading)
						$a[] = array($reading[0] * 1000, $reading[1]);
					return $a;
				}
				echo "var tide_predicted = " . json_encode(timestamptomilliseconds($predicted)) . ";";
				echo "var tide_observed = " . json_encode(timestamptomilliseconds($tideobservations)) . ";";
				?>
				$.plot($("#graph"), [
					{
						label: "Predicted tide height",
						data: tide_predicted,
						color: "#667"
					},
					{
						label: "Observed tide height",
						data: tide_observed,
						color: "#99f"
					}
				], {
					xaxis: {
						mode: "time",
						color: "#aaa"
					},
					yaxis: {
						color: "#aaa"
					},
					grid: {
						markings: [
							{ color: "#1d1", lineWidth: 1, xaxis: { from: <?php echo $now * 1000; ?>, to: <?php echo $now * 1000; ?> } },
							{ color: "#489", lineWidth: 2, yaxis: { from: <?php echo $lowthreshold; ?>, to: <?php echo $lowthreshold; ?>} },
							{ color: "#489", lineWidth: 2, yaxis: { from: <?php echo $highthreshold; ?>, to: <?php echo $highthreshold; ?>} }
						],
						backgroundColor: "#444"
					},
					legend: {
						show: true,
						position: "ne",
						container: $("#graph_legend"),
						noColumns: 2,
						color: "#aaa"
					}
				});
			});
		</script>
	</div>
</div>

<div class="contentarea" id="birdlist">
	<h2>Birds</h2>
	<dl class="single">
		<?php
		function birdlist($birds) {
			?>
			<ul>
			<?php foreach ($birds as $bird) { ?>
				<?php
				// make thumbnail for bird if we haven't already
				$imageurl = $bird->get("foaf:depiction");
				if (!$imageurl->isNull()) {
					if (!file_exists("thumbnails/" . md5($imageurl) . ".jpg")) {
						$img = new Imagick();
						$file = fopen((string) $imageurl, "rb");
						$img->readImageFile($file);
						fclose($file);
						$img->resizeImage(0, 96, Imagick::FILTER_LANCZOS, 1);
						$img->writeImage("thumbnails/" . md5($imageurl) . ".jpg");
						$img->destroy();
					}
				}
				?>
				<li>
					<a href="#birdinfo_<?php echo md5($bird); ?>" class="fancybox">
						<?php echo htmlspecialchars($bird->label()); ?>
						<?php if (!$imageurl->isNull()) { ?>
							<br>
							<img src="thumbnails/<?php echo md5($imageurl); ?>.jpg" alt="<?php echo htmlspecialchars($bird->label()); ?>">
						<?php } ?>
					</a>
				</li>
			<?php } ?>
			</ul>
			<?php
		}
		?>
		<dt>Birds common in current conditions</dt>
		<dd>
			<p class="hint">These birds are resident in the <?php echo $currentlevel; ?>-tide conditions currently found in the area</p>
			<?php birdlist($currentbirds); ?>
		</dd>
		<?php if (!is_null($higherbirds)) { ?>
			<dt>Birds you may additionally see if the tide gets higher</dt>
			<dd>
				<p class="hint">These additional birds may appear if the tide level increases</p>
				<?php birdlist($higherbirds); ?>
			</dd>
		<?php } ?>
		<?php if (!is_null($lowerbirds)) { ?>
			<dt>Birds you may additionally see if the tide gets lower</dt>
			<dd>
				<p class="hint">These additional birds may appear if the tide level decreases</p>
				<?php birdlist($lowerbirds); ?>
			</dd>
		<?php } ?>
	</dl>
</div>
<div class="hidden" id="birdinfo">
	<?php foreach ($allbirds as $bird) { ?>
		<div id="birdinfo_<?php echo md5($bird); ?>">
			<h2>
				<?php echo htmlspecialchars($bird->label()); ?>
				<a class="uri" href="<?php echo $bird; ?>"></a>
			</h2>
			<?php if (!$bird->get("foaf:depiction")->isNull()) { ?>
				<div>
					<img src="<?php echo htmlspecialchars($bird->get("foaf:depiction")); ?>">
				</div>
			<?php } ?>
			<?php if ($bird->get("dct:description")->nodeType() == "#literal") { ?>
				<p><?php echo $bird->get("dct:description"); ?></p>
			<?php } ?>
			<h3>Links</h3>
			<ul>
				<li><a href="<?php echo $bird; ?>"><?php echo htmlspecialchars($bird->label()); ?> at BBC Nature</a></li>
				<li><a href="<?php echo $bird->get("owl:sameAs"); ?>"><?php echo htmlspecialchars($bird->label()); ?> at DBPedia</a></li>
			</ul>
		</div>
	<?php } ?>
</div>
<div class="contentarea">
	<h2>Nearby amenities</h2>

	<dl class="single">
		<dt><?php echo count($pubbar); ?> pubs/bars</dt>
		<dd><?php amenitylist($pubbar); ?></dd>

		<dt><?php echo count($cafe); ?> cafés</dt>
		<dd><?php amenitylist($cafe); ?></dd>

		<dt><?php echo count($restaurant); ?> restaurants/fast food/barbecues/bakeries</dt>
		<dd><?php amenitylist($restaurant); ?></dd>

		<dt><?php echo count($shop); ?> food/drink shops</dt>
		<dd><?php amenitylist($shop); ?></dd>

		<dt><?php echo count($parking); ?> places to park</dt>
		<dd><?php amenitylist($parking); ?></dd>
	</dl>
</div>
</div>
</body>
</html>
<?php


?>
