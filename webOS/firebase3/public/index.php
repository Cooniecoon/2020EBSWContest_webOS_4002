<html>
<head>
<style>
/* iframe 배율 조절 */
iframe {
    zoom: 0.5; -moz-transform: scale(0.5); -moz-transform-origin: 0 0;
}
 
</style>
 
</head>
<body>
 
<form action="xframetest.php" method="get">
URL : <input type="text" name="url" />
<input type="submit" />
</form>
<p>
Output : <?php echo $_GET["url"]; ?><br>
<iframe src='<?php echo $_GET["url"]; ?>' width="1200" height="700" style="zoom" scrolling="no"></iframe>
</p>
 
<!-- X-Frame-Options 우회 -->
<script type="text/javascript">
var iframe = document.getElementsByTagName('iframe')[0];
var url = iframe.src;
var getData = function (data) {
    if (data && data.query && data.query.results && data.query.results.resources && data.query.results.resources.content && data.query.results.resources.status == 200) loadHTML(data.query.results.resources.content);
    else if (data && data.error && data.error.description) loadHTML(data.error.description);
    else loadHTML('Error: Cannot load ' + url);
};
var loadURL = function (src) {
    url = src;
    var script = document.createElement('script');
    script.src = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20data.headers%20where%20url%3D%22' + encodeURIComponent(url) + '%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=getData';
    document.body.appendChild(script);
};
var loadHTML = function (html) {
    iframe.src = 'about:blank';
    iframe.contentWindow.document.open();
    iframe.contentWindow.document.write(html.replace(/<head>/i, '<head><base href="' + url + '"><scr' + 'ipt>document.addEventListener("click", function(e) { if(e.target && e.target.nodeName == "A") { e.preventDefault(); parent.loadURL(e.target.href); } });</scr' + 'ipt>'));
    iframe.contentWindow.document.close();
}
 
loadURL(iframe.src);
</script>
</body>
</html>
