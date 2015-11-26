var facebookShare = document.querySelector('[data-js="facebook-share"]');
var twitterShare = document.querySelector('[data-js="twitter-share"]');
var client = new ZeroClipboard(document.getElementById("copy-button"));

// Facebook
facebookShare.onclick = function(e) {
e.preventDefault();
var facebookWindow = window.open('http://www.facebook.com/sharer/sharer.php?u=https%3A//taunt.io/taunt/{{ taunt.id }}&title=Taunt', 'facebook-popup', 'height=350,width=600');
if(facebookWindow.focus) { facebookWindow.focus(); }
  return false;
}

// Twitter
twitterShare.onclick = function(e) {
  e.preventDefault();
  var twitterWindow = window.open('https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Ftaunt.io&url=' + document.URL + '&hashtags=taunt&via=taunt_io&text={{ taunt.title }}%20%2D', 'twitter-popup', 'height=350,width=600');
  if(twitterWindow.focus) { twitterWindow.focus(); }
    return false;
  }

// Copy URL to clipboard (ZeroClipboard)
client.on("ready", function(readyEvent) {
  // alert( "ZeroClipboard SWF is ready!" );
  client.on( "copy", function (event) {
    var clipboard = event.clipboardData;
    clipboard.setData( "text/plain", window.location.href );
  });
  client.on("aftercopy", function(event) {
    // DO SOMETHING AFTER COPY
    // `this` === `client`
    // `event.target` === the element that was clicked
    // event.target.style.display = "auto";
    // alert("Copied text to clipboard: " + window.location.href);
  });
});

// Tooltip
Tipped.create('#copy-button', 'URL copied to clipboard :)', { showOn: 'click', position: 'bottom', fadeIn: 0 });
