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

$cachedir = "cache/graphite";

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
		$offset = $time - strtotime("2011-01-02");//TODO: remove!
	$predicted[] = array(($time - $offset), trim($height));//TODO: remove offset!
}

// current time
$now = strtotime("2011-01-02 19:48"); //TODO: replace this with current time

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

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Birdwatching mashup</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="flot/jquery.flot.min.js"></script>
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

			// link the bird list
			choosebird = function(id) {
				if (typeof(id) != "string")
					var id = $(this).attr("id").split("_")[1];
				$("#birdinfo > div").hide();
				$("#birdinfo_" + id).show();
			};
			$("#birdlist li").click(choosebird);
			choosebird("start");
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
		.contentarea {
			position: absolute;
			background-color: #333;
			overflow-y: auto;
			overflow-x: hidden;
		}
		#graphpane {
			top: 3em;
			bottom: 61%;
			width: 100%;
		}
		#birdlist {
			bottom: 0;
			width: 25%;
			height: 60%;
		}
		#infopane {
			bottom: 0;
			right: 0;
			width: 74%;
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
		#birdlist ul {
			margin: 0 0 0 1.5em;
		}
		#birdlist li {
			margin: 0.5em 0;
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
		.pad {
			padding: 0.5em;
		}
		#birdlist li:hover {
			cursor: pointer;
			color: #aca;
			text-decoration: underline;
		}
	</style>
</head>
<body>
<div class="contentarea" id="birdlist">
	<div class="pad">
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
						if (!file_exists("cache/thumbnails/" . md5($imageurl) . ".jpg")) {
							$img = new Imagick();
							$file = fopen((string) $imageurl, "rb");
							$img->readImageFile($file);
							fclose($file);
							$img->resizeImage(0, 96, Imagick::FILTER_LANCZOS, 1);
							$img->writeImage("cache/thumbnails/" . md5($imageurl) . ".jpg");
							$img->destroy();
						}
					}
					?>
					<li id="birdlist_<?php echo md5($bird); ?>">
						<h3><?php echo htmlspecialchars($bird->label()); ?></h3>
						<?php if (!$imageurl->isNull()) { ?>
							<img src="cache/thumbnails/<?php echo md5($imageurl); ?>.jpg" alt="<?php echo htmlspecialchars($bird->label()); ?>">
						<?php } ?>
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
</div>
<div class="contentarea" id="infopane">
	<div class="pad">
		<div id="birdinfo">
			<div id="birdinfo_start">
				<h2>Welcome to the birdwatching mashup</h2>
				<p>Some birds you may see in the area are listed in the panel on the left under various categories.</p>
				<p>Click a species to see information about it.</p>
			</div>
			<?php foreach ($allbirds as $bird) { ?>
				<div id="birdinfo_<?php echo md5($bird); ?>">
					<h2>
						<?php echo htmlspecialchars($bird->label()); ?>
						<a class="uri" href="<?php echo $bird; ?>"></a>
					</h2>
					<?php echo $bird->dump(); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="contentarea" id="graphpane">
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
</body>
</html>
<?php


?>
