var client = new ZeroClipboard(document.getElementById("copy-button"));

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
