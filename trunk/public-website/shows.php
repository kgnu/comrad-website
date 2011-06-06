<?php
  
  if (isset($_GET['id'])) {
    $event_id = strtolower($_GET['id']);
  }

  if (isset($_GET['name'])) {
    $show_name = strtolower($_GET['name']);
    switch ($show_name)
    {
    case "asa":
      $event_id = 1;
      break;
    case "afternoonsound":
      $event_id = 1;
      break;
    case "sleepless":
      $event_id = 21;
      break;
    case "restless":
      $event_id = 22;
      break;
    case "honktonk":
      $event_id = 23;
      break;
    case "gospel":
      $event_id = 24;
      break;
    case "bluegrass":
      $event_id = 25;
      break;
    case "rootsandbranches":
      $event_id = 26;
      break;
    case "etown":
      $event_id = 27;
      break;
    case "tributaries":
      $event_id = 28;
      break;
    case "terrasonic":
      $event_id = 29;
      break;
    case "livingdialogs":
      $event_id = 30;
      break;
    case "reggae":
      $event_id = 31;
      break;
    case "celtic":
      $event_id = 32;
      break;
    case "musica":
      $event_id = 33;
      break;
    case "morningsound":
	case "msa":
	  $event_id = 67;
	  break;
    }
  }
  
  $event_type = 'Show';
  if (isset($_GET['type'])) {
    $event_type = $_GET['type'];
  }

?>

<?php include("header.php"); ?>


  <script type="text/javascript">
  /* <![CDATA[ */
  
  //preload the "Hide" images so that they can display immediately when JavaScript switches
  //the images to display them
  var img1 = new Image();
  img1.src = "btns/2/HidePlaylist.gif";
  var img2 = new Image();
  img2.src = "btns/2/HideDetail.gif";

  var d_names = new Array("Sunday", "Monday", "Tuesday",
        "Wednesday", "Thursday", "Friday", "Saturday");


  function myToggle(divId) {
    $('#'+ divId).toggle();
  }

  /*function setNewClickAction(divId, aId) {
    
    //$('#'+ divId).unbind('click').click(myToggle(divId));
    // $('#'+ aId).removeAttr('onclick').click(myToggle(divId));
    $('#'+ aId).unbind('click').click(function() { $('#'+ divId).toggle(); } ); 

  }*/

	var trackListing;
	var alternatingRow;
  function populatePlaylist(showId, divId, aId)
  {

    $.get('http://kgnu.net/playlist/ajax/getfullplaylistforshowinstance.php', {
      showid: showId
    }, function(results) {

      if (!results) {
        return;
      }

      results.sort(function(a, b) {
        return b.Attributes.StartDateTime - a.Attributes.StartDateTime;
      });

      $('#'+ divId).empty();

	  trackListing = 
				"<table cellpadding='2' cellspacing='0' style='border-style:collapse' class='playlist'>" +
				"<tr class='head'><td>Artist</td><td>CD</td><td>Track</td></tr>";
	  alternatingRow = false;
      $.each(results, function(index, value) {

        if (value.Type) {
          var playlistType = value.Type;
          if (playlistType == "TrackPlay") {

            if (value.Attributes.Track && value.Attributes.Track.Type && value.Attributes.Track.Type == "Track" && value.Attributes.Track.Attributes) {
              var track = value.Attributes.Track.Attributes.Title;
              
              var artist;
              if (value.Attributes.Track.Attributes.Album.Attributes.Artist) {
                artist = value.Attributes.Track.Attributes.Album.Attributes.Artist;
              }
              var cd;
              if (value.Attributes.Track.Attributes.Album.Attributes.Title) {
                cd = value.Attributes.Track.Attributes.Album.Attributes.Title;
              }
				
			  trackListing += "<tr " + (alternatingRow ? 'class="alternatingRow"' : '') + ">" +
								"<td>" + (!artist?"": artist) + "</td>" +
								"<td>" + (!cd?"": cd) + "</td>" +
								"<td>" + track + "</td>" +
							  "</tr>";
			  if (alternatingRow) {
				alternatingRow = false;
			  } else {
				alternatingRow = true;
			  }
            }
          }
        }
      });
	  trackListing += "</table>";
	  $('#' + divId + " .loading").remove();
	  $('#'+ divId).append(trackListing);
    }, 'jsonp');

    //setNewClickAction(divId, aId);
    $('#'+ divId).show();

      // $('#'+ divId).html(results);
      // $('#'+ divId).show();
  }


  function populateShows(start, end)
  {
  
	$.get('http://kgnu.net/playlist/ajax/geteventsbetween.php', {
      start: start,
      end: end,
      types: $.toJSON([ 'Show' ])
	  <?php if (isset($event_id)) { ?>,eventparameters: $.toJSON({  'Id': <?php echo $event_id; ?>  }) <?php } ?>
    }, function(results) {
		
      if (!results) {
        return;
      }
	  
	  results.sort(function(a, b) {
        return b.Attributes.StartDateTime - a.Attributes.StartDateTime;
      });

      var lastDate;
      var dateContainer;
      var list;
	  
      $.each(results, function(index, value) {
		var longTime = value.Attributes.StartDateTime;
        var startTime = new Date(value.Attributes.StartDateTime * 1000);
        var duration = value.Attributes.Duration;
        var endTime = new Date(startTime.getTime() + duration * 60 * 1000);
        var startDay = startTime.getDay();
        var startDate = startTime.getDate();
        var startMonth = startTime.getMonth();
        startMonth++;
        var startYear = startTime.getFullYear();

        /**
         * Get the Show Title
         */
        var title;
        if (value.Attributes.ScheduledEvent.Attributes.Event.Attributes.Title) { 
          title = value.Attributes.ScheduledEvent.Attributes.Event.Attributes.Title;
		  //set the show title in the header sw 5/30/11
		  if (getUrlParameter("name") || getUrlParameter("id")) {
			$("#pageTitle").html(title);
		  }
        }
        
	    list = $("#shows .showInstanceList");

        /**
         * Get the Show Short Description
         */
        var shortDescription;
        if (value.Attributes.ShortDescription) {
          shortDescription = value.Attributes.ShortDescription;
        }
        //if (!shortDescription && value.Attributes.ScheduledEvent.Attributes.Event.Attributes.ShortDescription) {
		//	shortDescription = value.Attributes.ScheduledEvent.Attributes.Event.Attributes.ShortDescription;
        //}

        /**
         * Get the Show Long Description
         */
        var longDescription;
        if (value.Attributes.LongDescription) {
          longDescription = value.Attributes.LongDescription;
        }
        //if (!longDescription && value.Attributes.ScheduledEvent.Attributes.Event.Attributes.LongDescription) {
        //   longDescription = value.Attributes.ScheduledEvent.Attributes.Event.Attributes.LongDescription;
        //}

        /**
         * Get the Show ID
         */
        var playlist = "";
        var playlistSpanId = "";
        var playlistDivId = "";
        var playlistAId;
        var showId;
        if (value.Attributes.Id) {
          showId = value.Attributes.Id;
          playlistSpanId = longTime + "_PlaylistSpanId";
          playlistDivId = longTime + "_PlaylistDivId";
          playlistAId = longTime + "_PlaylistAId";
		  //determine the button type to show
		  var buttonType;
		  switch (value.Attributes.ScheduledEvent.Attributes.Event.Attributes.Category) {
			case "Music":
				buttonType = "Playlist";
				break;
			case "NewsPA":
				buttonType="Detail";
				break;
			default:
				buttonType="Playlist";
				break;
		  }
          playlist = "<span id=\"" + playlistSpanId + "\" title=\"View Playlist\"><a id=\"" + playlistAId + "\" showId=\"" + showId + "\" playListDivId=\"" + playlistDivId + "\" playlistAId=\"" + playlistAId + "\" href=\"#\"><img src=\"btns/2/Show" + buttonType + ".gif\" /></a></span>";
          //playlist = $('<span id=\"" + divId + "\" title=\"View Playlist\"><a href=\"javascript:;\">Playlist</a></span>').click(function() {
          //	populatePlaylist('" + showId + "', '" + playlistDiv + "');
          //});
        }

        /**
         * Get the Host ID
         */
        var hostId;
        if (value.Attributes.HostId) {
          hostId = value.Attributes.HostId;
        }
        if (!hostId && value.Attributes.Host && value.Attributes.Host.Attributes.UID) {
          hostId = value.Attributes.Host.Attributes.UID;
        }
        if (!hostId && value.Attributes.ScheduledEvent.Attributes.Event.Attributes.HostId) {
          hostId = value.Attributes.ScheduledEvent.Attributes.Event.Attributes.HostId;
        }

        /**
         * Get the Host Name
         */
        var hostName;
        if (value.Attributes.Host && value.Attributes.Host.Attributes.Name) {
          hostName = value.Attributes.Host.Attributes.Name;
        }
        if (!hostName && value.Attributes.ScheduledEvent.Attributes.Event.Attributes.Host) {
          hostName = value.Attributes.ScheduledEvent.Attributes.Event.Attributes.Host.Attributes.Name;
        }

        /**
         *
         */
        var hostURL;
        if (hostId && hostName) {
          hostURL = "<a href=\"hosts.php?id=" + hostId + 
                    "\" title=\"Click for all " + hostName + "'s shows\">" + hostName + "</a>"; 
        }
        if (hostURL) {
          hostName = hostURL;
        }

        /**
         * Get the Show Recorded Audio
         */
        var eventHasRecordedAudio;
        if (value.Attributes.ScheduledEvent.Attributes.Event.Attributes.RecordAudio) {
          eventHasRecordedAudio = value.Attributes.ScheduledEvent.Attributes.Event.Attributes.RecordAudio;
        }

        var player = "";
        var eventRecordedAudioURL;
        if (value.Attributes.RecordedFileName) {
          eventRecordedAudioURL = value.Attributes.RecordedFileName;
          player = "<span id=\"" + longTime + "_Player\" title=\"Play and preview track\" class=\"jplayer-albumdetails\"><a id=\"" + longTime + "_PlayButton\" class=\"jplay-button play\" onClick=\"SampleSelected('http://www.kgnu.net/audioarchives/" + eventRecordedAudioURL + "', this);\" href=\"javascript:;\"></a></span>";
        }
                
        list.append(
			'<li class="showInstance">' +
				'<div class="showTitleContainer"><div class="showTitle">' + 
					(!title || getUrlParameter("name") || getUrlParameter("id") ?"": title + ", " ) +
					d_names[startDay] + ', ' + startMonth + '/' + startDate + '/' + startYear +
				'</div><div class="clear">.</div></div>' +
				'<div class="spacer">&nbsp;</div>' +
				(!hostName ? "": '<div class="showDetail">Host: ' + hostName + '</div>') +
				(!shortDescription ? '' : '<div class="showDetail">' + shortDescription + '</div>') +
				(!longDescription ? '' : '<div class="showDetail longDescription">' + longDescription + '</div>') +
				'<div class="showDetail playlistContainer">' + playlist + '</div>' +
				'<div class="showDetail">' + player + '</div>' +
				'<div id="' + playlistDivId + '" class="showDetail">' + '</div>' +
			 '</li>'); //sw 6/5/11 changed

		// Add a click handler to the anchor tag inside of the content div
		if (playlistAId) {
			$('#' + playlistAId).click(function(eventObject) {
				eventObject.preventDefault(); //prevent the default click action
				
				//if the playlist has not been populated yet, do so
				if (!$(this).is("[playlistPopulated]")) {
					//add a loading notification
					$("#" + $(this).attr("playListDivId")).append('<div class="loading">Loading Playlist...</div>');
					populatePlaylist($(this).attr("showId"), $(this).attr("playListDivId"), $(this).attr("playlistAId"));
					$(this).attr("playlistPopulated","1");
				} else {
				
					//show/hide the div
					$("#" + $(this).attr("playListDivId")).toggle();
					
					// sw 6/2/11 - removed this code
					/*
					// Inside of the click handler, 'this' references the clicked element (anchor tag)
					// Save a reference to it so we can access it in the AJAX success callback.
					var anchorTag = $(this);
					
					// Unbind the previously added click handler
					// Do this immediately to prevent double clicks
					anchorTag.unbind('click');
					
					// Show the loading text
					$('#' + playlistAId).show();
					
					$.ajax({
						url: 'http://kgnu.net/playlist/ajax/getfullplaylistforshowinstance.php',
						dataType: 'jsonp',
						data: {
							showid: showId // Reggae Bloodlines 5/28/11 1 to 4pm
						},
						success: function(playlistItems) {
							// Sort the playlist items by the 'Executed' attribute
							playlistItems.sort(function(a, b) {
								return a.Attributes.Executed - b.Attributes.Executed;
							});
							
							// Create a list element to be inserted later
							var list = $('<ul />');
							
							// Add a list element for each playlist item
							for (var i = 0; i < playlistItems.length; i++) {
								// Expand this to handle all of the different playlist item types
								list.append(
									$('<li>' + playlistItems[i].Type + '</li>')
								);
							}
							
							// All done; Hide the loading text
							$('#' + playlistAId).hide();
							
							// Add the list element to the content div
							$('#' + playlistSpanId).append(list);
							
							// Bind a new click handler on the anchor tag
							// to simply toggle the visibility of the list element
							anchorTag.click(function(eventObject) {
								list.toggle();
							});
						},
						error: function() {
							anchorTag.hide();
							$('#' + playlistDivId).hide();
							$('#' + playlistDivId).append('<p>There was an error retrieving the playlist.</p>');
						}
					});*/
				}
				
				//change the image from "show" to "hide"
				//sw 6/5/11 - changed these from using "==" to find the image name to using indexOf, since
				//IE sets the SRC property to a full URL
				if ($(this).find("img").attr("src").indexOf("btns/2/ShowPlaylist.gif") != -1) {
					$(this).find("img").attr("src","btns/2/HidePlaylist.gif");
				} else if ($(this).find("img").attr("src").indexOf("btns/2/HidePlaylist.gif") != -1) {
					$(this).find("img").attr("src","btns/2/ShowPlaylist.gif");
				} else if ($(this).find("img").attr("src").indexOf("btns/2/ShowDetail.gif") != -1) {
					$(this).find("img").attr("src","btns/2/HideDetail.gif");
				} else if ($(this).find("img").attr("src").indexOf("btns/2/HideDetail.gif") != -1) {
					$(this).find("img").attr("src","btns/2/ShowDetail.gif");
				}
			}); 
		}
      });
    }, 'jsonp');
  }

  $(function() { 
	//sw 5/30/11 - if the shows is for all shows, show "Recent Shows" in the header
	if (!getUrlParameter("name") && !getUrlParameter("id")) {
		$("#pageTitle").html("Recent Shows");
    }
    // Populate the default date range...
    //populateShows('<?php echo max(date('Y-m-d H:i:s', strtotime('-30 day')),date('Y-m-d H:i:s',strtotime('5/31/2011'))); ?>', '<?php echo date('Y-m-d H:i:s'); ?>');
	//var now = new Date();
	//var nowStr = now.format("yyyy-mm-dd HH:MM:ss");
	//get all events in the next day
	var nowStr = "<?php echo max(date('Y-m-d H:i:s', strtotime('-30 day')),date('Y-m-d H:i:s',strtotime('5/31/2011'))); ?>";
	var then = new Date();
	var thenStr = then.format("yyyy-mm-dd HH:MM:ss");
	populateShows(nowStr, thenStr);
  });
  
  //sw 5/30/11 - url parameters function from http://www.netlobo.com/url_query_string_javascript.html
	function getUrlParameter( name ) {
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
		return "";
	  else
		return results[1];
	}

  /* ]]> */
  </script>

<div id="shows">
	<ul class="showInstanceList"></ul>
	<div class="priorShows">
		Looking for shows prior to June 1st, 2011? <a href="http://kgnu.org/ht/listings.html?date=2011-05-31&show=All&host=All&display=list">Go here</a>.
	</div>
</div>

<?php include("footer.php"); ?>


