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
  
  <?php
	//sw 6/6/11 - if the "name" or "id" GET parameters are set, 
	//we'll show the name of the show
	//otherwise, we'll show "Recent Shows" as the title
	//the JavaScript variable isSpecificShow will be used to keep track of this
	if (isset($_GET["name"]) || isset($_GET["id"])) {
		echo 'var isSpecificShow = true;';
	} else {
		echo 'var isSpecificShow = false;';
	}
  ?>
  
  //preload the "Hide" images so that they can display immediately when JavaScript switches
  //the images to display them
  var img1 = new Image();
  img1.src = "btns/2/HidePlaylist.gif";
  var img2 = new Image();
  img2.src = "btns/2/HideDetail.gif";

  var dayNames = new Array("Sunday", "Monday", "Tuesday",
        "Wednesday", "Thursday", "Friday", "Saturday");


	var trackListing;
	var alternatingRow;
  function populatePlaylist(showId, divId, aId, type)
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

	  trackListing = "<table cellpadding='2' cellspacing='0' style='border-style:collapse' class='playlist'>";
	  if (type == "Playlist") {
		trackListing += "<tr class='head'><td>Artist</td><td>CD</td><td>Track</td></tr>";
	  }
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
		
		//remove the loading image
		$(".loadingImage").remove();
		
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
		  if (isSpecificShow) {
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
          playlist = "<span id=\"" + playlistSpanId + "\" title=\"View Playlist\">" +
				"<a id=\"" + playlistAId + "\" showId=\"" + showId + "\" playListDivId=\"" + playlistDivId + "\" playlistAId=\"" + playlistAId + "\" type=\"" + buttonType + "\" href=\"#\">" +
					"<img src=\"btns/2/Show" + buttonType + ".gif\" />" +
				"</a>" +
			"</span>";
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
					(!title || isSpecificShow ?"": title + ", " ) +
					dayNames[startDay] + ', ' + startMonth + '/' + startDate + '/' + startYear +
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
					if ($(this).attr("type") == "Playlist") {
						$("#" + $(this).attr("playListDivId")).append('<div class="loading">Loading Playlist...</div>');
					} else {
						$("#" + $(this).attr("playListDivId")).append('<div class="loading">Loading Details...</div>');
					}
					populatePlaylist($(this).attr("showId"), $(this).attr("playListDivId"), $(this).attr("playlistAId"), $(this).attr("type"));
					$(this).attr("playlistPopulated","1");
				} else {
				
					//show/hide the div
					$("#" + $(this).attr("playListDivId")).toggle();
					
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
	if (!isSpecificShow) {
		$("#pageTitle").html("Recent Shows");
    }
    // Make an AJAX call to get recent shows from the server
	var nowStr = "<?php echo max(date('Y-m-d H:i:s', strtotime('-30 day')),date('Y-m-d H:i:s',strtotime('5/31/2011'))); ?>";
	var then = new Date();
	var thenStr = then.format("yyyy-mm-dd HH:MM:ss");
	populateShows(nowStr, thenStr);
  });

  /* ]]> */
  </script>

<div id="shows">
	<div class="loadingImage"><img src="/graphics/ajax-loader.gif" alt="Loading" /></div>
	<ul class="showInstanceList">
	</ul>
	<div class="priorShows">
		Looking for shows prior to May 31st, 2011? <a href="http://kgnu.org/ht/listings.html?date=2011-05-30&show=All&host=All&display=list">Go here</a>.
	</div>
</div>

<?php include("footer.php"); ?>


