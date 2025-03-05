<?php

if (isset($_GET['q'])) {

    $feeds = [
        "Google" => "http://news.google.com/news?ned=us&topic=h&output=rss",
        "ZDN" => "https://www.zdnet.com/news/rss.xml"
    ];

    if (array_key_exists($_GET['q'], $feeds)) {

        $xml = simplexml_load_file($feeds[$_GET['q']]);

        if ($xml === false) {
            die("Error: Unable to load RSS feed.");
        }

        echo "<h2><a href='{$xml->channel->link}' target='_blank'>{$xml->channel->title}</a></h2>";

        foreach ($xml->channel->item as $item) {
            echo "<p><a href='{$item->link}' target='_blank'>{$item->title}</a></p>";
        }
    } else {
        die("Error: Invalid RSS feed selection.");
    }

    exit(); // Prevent HTML below from being loaded
}

?>

<!DOCTYPE html>
<html>

<head>

<script>
function showRSS(feed) {
    if (!feed) return;

    fetch(`webfeed.php?q=${feed}`)
        .then(response => response.text())
        .then(data => document.getElementById("rssOutput").innerHTML = data)
        .catch(error => console.error("Error fetching RSS feed:", error));
}
</script>

</head>

<body>

<!-- Dropdown for selecting RSS feed-->

<form>

    <select onchange="showRSS(this.value)">
        <option value="">Select an RSS-feed: </option>
        <option value="Google">Google News</option>
        <option value="ZDN">ZDNet News</option>
    </select>

</form>

<!-- Div where RSS feed will be displayed -->

<div id="rssOutput">RSS feed will be displayed here...</div>

</body>

</html>
