<?php header("Content-type: text/html");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta name="author" content="Genjix" />
  <meta name="keywords" content="nobody" />
  <meta name="description" content="none" />
  <meta name="robots" content="all" />
  <link rel="icon" type="image/png" href="favicon.png" />

  <title>genjix</title>

  <script src="ajax_request.js" type="text/javascript"></script>
  <script type="text/javascript" src="audio/audio-player.js"></script>
  <script type="text/javascript">
AudioPlayer.setup("audio/player.swf", {
  width: 290
});

var current_hash = location.hash;

function Load(page)
{
  AjaxRequest.get(
    {
      'url':"parse.php?page=" + page,
      'onSuccess':function(req)
	{
	  document.getElementById("content").innerHTML = req.responseText;
	}
    }
  );
  location.hash = "#" + page;
  current_hash = location.hash;
}
function CheckHash()
{
  if (location.hash != current_hash)
    Load(location.hash.substr(1));
}

function UpdateEq()
{
  AjaxRequest.get(
    {
      'url':'genjix.php',
      'onSuccess':function(req)
	{
	  var eq = document.getElementById("equalizer").style;
	  eq.background = "url(" + req.responseText + ")";
	  eq.backgroundRepeat = "no-repeat";
	  eq.backgroundPosition = "bottom left";
	}
    }
  );
}
function Init()
{
  setInterval('UpdateEq()',9900);
  setInterval('CheckHash()',200);
  if (location.hash != "")
    Load(location.hash.substr(1));
  else
    Load("esperanto");
  UpdateEq();
}
  </script>

  <style type="text/css" media="all">
    @import "181.css";
  </style>
</head>

<body onload="Init();">

<div id="container">
    <div id="pageHeader"></div>

    <div id="quickSummary">
      <p>Years of <acronym title="Evolution">evolution</acronym> in the making.</p>
      <p>Follow on <a href="http://youtube.com" title="youtube">file</a> and
	<a href="http://google.com" title="google">session</a></p>
    </div>

  <p id="audioplayer"></p>
  <script type="text/javascript">
    AudioPlayer.embed("audioplayer", {
  soundFile: "http://www.fileden.com/files/2009/8/19/2548465/xproj.mp3,http://www.fileden.com/files/2009/8/19/2548465/intro.mp3",
  titles: "X-Project (100% Pure Mix), Paul Hartnoll's intro",
  loop: "yes",
  autostart: "yes",
  width: 195,
  initialvolume: 100,
  bg: "ff0066",
  leftbg: "ff0066",
  lefticon: "FFFFFF",
  rightbg: "ff0066",
  rightbghover: "ff0066",
  righticon: "ffffff",
  righticonhover: "000000",
  volslider: "ffffff",
  voltrack: "ff7fb2",
  loader: "ff0066",
  track: "ff0066",
  tracker: "ff7fb2",
  border: "ff0066",
  skip: "ffffff",
  text: "ffffff",
  pagebg: "FF0066"
  });
  </script>

    <div id="equalizer"></div>

  <div id="content">
<!-- expendable -->
<!-- expendable -->
  </div>

  <div id="linkList">
    <div id="lselect">
      <h3 class="select"></h3>
	<ul>
<?php include("findarts.php"); ?>
	</ul>
    </div>

    <div id="larchives">
      <h3 class="archives"></h3>
      <ul>
	<li><a href="javascript:NextArticle()" title="View next article. AccessKey: n"><span class="accesskey">n</span>ext article</a>&nbsp;</li>
	<li><a href="javascript:PreviousArticle()" title="View previous article. AccessKey: p" accesskey="p"><span class="accesskey">p</span>revious article</a></li>
	<li><a href="about:blank" title="Selection screen of all articles. AccessKey: w" accesskey="w">Vie<span class="accesskey">w</span> All articles</a></li>
      </ul>
    </div>

    <div id="lresources">
      <h3 class="resources"></h3>
      <ul>
	<li><a href="http://www.couchsurfing.org/people/genjix/" target="_blank" title="Surf Genjix's couch! AccessKey: c" accesskey="c">Genjix's <span class="accesskey">C</span>ouch</a></li>
    <li><a href="http://www.flickr.com/photos/genjix" target="_blank" title="Flickr photos! AccessKey: f" accesskey="f"><span class="accesskey">F</span>lickr</a></li>
    <li><a href="#faq" title="A list of Frequently Asked Questions. AccessKey: q" accesskey="q"><acronym title="Frequently Asked Questions">FA<span class="accesskey">Q</span></acronym></a>&nbsp;</li>
	<li><a href="mailto:genjix@gmail.com" target="_blank" title="Contact Genjix. AccessKey: c" accesskey="c"><span class="accesskey">C</span>ontact</a></li>
      </ul>
    </div>
  </div>

</div>

</body>
</html>
