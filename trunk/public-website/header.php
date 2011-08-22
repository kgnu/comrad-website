<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

  <head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
    <title>KGNU Independent Community Radio / 88.5 FM & 1390 AM (Boulder / Denver) / 93.7 FM (Nederland)</title>

    <base href="/">

    <meta name="keywords" content="KGNU independent commmunity radio, Boulder, Denver, Free-form, Freeform, Free Form Music, BBC news, Democracy Now, Reggae Bloodlines, Honky Tonk Heroes, Old Grass Gnu Grass, Bluegrass, radio, community radio, Ragtime America">
    <meta name="description" content="KGNU Independent Community Radio broadcasting at 88.5 FM in Boulder and 1390 AM in Denver. Listener supported, volunteer powered community radio.">
    <META name="verify-v1" content="+puZM4YBac9YXeqlsUo0amK5WHLvMOt6bJQdFGP13dM=">
    <link rel="shortcut icon" href="favicon.ico">
    <!-- <link rel="alternate" href="kgnu.rss" type="application/rss+xml" title="KGNU RSS Feed"> -->
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" media="screen, print">
    <script language="javascript" type="text/javascript" src="js/thermometer.js"></script>
    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

    <link rel="StyleSheet" href="css/default.css" type="text/css" />
    <!-- <link rel="StyleSheet" href="http://www.jplayer.org/latest/skin/jplayer.blue.monday.css" type="text/css" /> -->
    <link rel="StyleSheet" href="css/kgnu.jplayer/kgnu.jplayer.css" type="text/css" />
    <style type="text/css">
        body {background-image: none;}
		/* sw 5/30/11 */
		.showInstanceList {
			margin:20px 15px 5px;
			padding:0;
			list-style-type:none;
		}
		.showInstance {
			border:1px solid #AAAAAA;
			padding:5px;
			margin-bottom:30px;
		}
		a img {
			outline:none;
			border:none;
		}
		.showTitleContainer {
			height:1px;
			position:absolute;
		}
		.showTitle {
			padding:2px 4px;
			float:left;
			background:#fff;
			position:relative;
			top:-19px;
			/*border:1px solid #AAAAAA;*/
			color:#009999;
		}
		div.clear {
			clear:both;
			display:block;
			height:0;
			line-height:0; /* enforce height:0 in ie6 */
			visibility:hidden;
		}
		.spacer {
			line-height:8px;
			height:8px;
		}
		.showInstance .showDetail {
			padding-bottom:5px;
			padding-left:4px;
		}
		.showDate {
			font-style:italic;
		}
		.longDescription p {
			margin:0;
		}
		.showInstance .playlistContainer {
			margin-top:10px;
		}
		.playlist {
			border:1px solid #444;
			width:100%;
		}
		.playlist td {
			border-bottom: 1px solid #CCC;
		}
		.playlist .head {
			font-weight:bold;
			background-color:#B7BBC4;
		}
		.playlist .alternatingRow {
			background-color:#eeeeee;
		}
		.loading {
			color:#999;
		}
		.loadingImage {
			text-align:center;
		}	
		.priorShows {
			margin-top:1em;
			font-size:14pt;
			margin-left:16px;
		}
		
		.voicebreak, .underwriting, .feature, .comment, .psa {
			padding-left: 40px;
			font-weight: bold;
			background-color: #F8F8E0;
			border: 0;
			color: #099;
			font-style: italic;
		}
		
		table.playlist td.comment {
			border-bottom: none;
		}
		
		.comment-body {
			padding-left: 60px;
			background-color: #F8F8E0;
		}
		
		/* css for short and long descriptions */
		.shortDescription {
			font-size:15px;
		}
		.longDescription {
			font-family:'Calibri',sans-serif !important;
			font-size:12px;
		}
		.longDescription p:first-child { /* won't work in early versions of IE, so this style is just a nice-to-have */
			margin-top:0;
		}
		.longDescription p {
			margin:.5em 0;
		}
      </style>
    <script type="text/javascript" src="js/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/jquery/ui/jquery-ui.js"></script>
    <script type='text/javascript' src='js/date/format/date.format.js'></script>
    <script type="text/javascript" src="js/jquery/json/jquery.json.js"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="js/jquery.jplayer.inspector.js"></script>

 
  <style type="text/css">

/*	.jplay-button,	.play-all {
		display:block;
		height:17px;
	}
	
	.jplayer-albumdetails .jplay-button, .jplayer-playall .play-all	{
		width:17px;
	}
	
	.jplayer-albumdetails .play, .jplayer-playall .play	{
		background:transparent url(http://www.kgnu.org/media/albumDetails.gif) no-repeat 0 0;
	}
	
	.jplayer-albumdetails .stop, .jplayer-playall .stop	{
		background:transparent url(http://www.kgnu.org/media/albumDetails.gif) no-repeat 0 -17px;
	}
	
	.jplayer-topsongs .jplay-button	{
		width:34px;
	}

	.jplayer-topsongs .play	{
		background:transparent url(http://www.kgnu.org/media/topsongs.gif) no-repeat 0 0;
	}

	.jplayer-topsongs .stop	{
		background:transparent url(http://www.kgnu.org/media/topsongs.gif) no-repeat 0 -17px;
	}*/

  </style>
 
    <script type="text/javascript">

        var currentPlaylistIndex = 0;
        
        var albumPlayList = [{name:'Vocalise',mp3:'http://www.kgnu.org/media/sophieserafino5-01.mp3'}];
    
        function SampleSelected(fileLocation, callingParty)
        {
            if ($(callingParty).hasClass("play"))
            {
                $(".jplay-button").removeClass("stop").addClass("play");
                $(".play-all").removeClass("stop").addClass("play");
                $(".now-playing").text("preview all songs");
                $("#jquery_jplayer").jPlayer("setMedia", { mp3: fileLocation }).jPlayer("play");
                // $("#jquery_jplayer").jPlayer("setFile", fileLocation).jPlayer("play");
                $(callingParty).removeClass("play").addClass("stop");
            }   // if
            else
            {
                $("#jquery_jplayer").jPlayer("pause");
                $(callingParty).removeClass("stop").addClass("play");
            }   // else
            
            $("#jquery_jplayer").jPlayer("onSoundComplete", function() 
                {
                    $(callingParty).removeClass("stop").addClass("play");
	            });

        }     
        
        function PlayAll()
        {
            if ($(".play-all").hasClass("play"))
            {
                currentPlaylistIndex = 0;
            
                $(".play-all").removeClass("play").addClass("stop");
                $(".jplay-button").removeClass("stop").addClass("play");             
                                   
                $("#jquery_jplayer").jPlayer("onSoundComplete", function() 
                    {
                        currentPlaylistIndex++;
                        PlaySampleFromPlayList();        
                    });
                    
                PlaySampleFromPlayList();
            }   // if
            else
            {
                $(".play-all").removeClass("stop").addClass("play");
                $("#jquery_jplayer").jPlayer("pause");
                $(".now-playing").text("preview all songs");
                
                $("#jquery_jplayer").jPlayer("onSoundComplete", function() 
                    {
                    });                
            }   // else  
        }   
        
        function PlaySampleFromPlayList()
        {
            if (currentPlaylistIndex == albumPlayList.length)
            {
                $(".play-all").removeClass("stop").addClass("play");
                $(".now-playing").text("preview all songs");
            }   // if
            else
            {
                $("#jquery_jplayer").jPlayer("setFile", albumPlayList[currentPlaylistIndex].mp3).jPlayer("play");
                $(".now-playing").text("Now Playing: " + albumPlayList[currentPlaylistIndex].name);
                
            }   // else
        }   
    
        function TrackChoiceMade()
        {
            returnValue = false;

            $(".check-download-track input").each(function() {
                if ($(this).attr("checked") == true) { returnValue = true; }
            });
            
            if ( returnValue == false ) { alert("Please choose a track to download."); }
            
            return returnValue;
        }
        function ValidateReview()
        {
            returnValue = false;
            if(checkReviewsForm())
            {
                $.openModal({target:'#divReviewed'});
                returnValue = true;
            }
            return returnValue;
        }
    </script>

  </head>

  <!--// BROWSER NOTES -->
  <!-- the <TD WIDTH=1> statements are so that Netscape won't add 1 or 2 extra pixels to the width of a cell -->
  <!-- don't leave any space characters between <A> and </A>, or Netscape and Opera will add an underlined blank charater -->
  <!-- TDs with an image must be written all in one line, else Netscape and IE add 5 pixels below a cell -->

  	<body style="background-color:#F8F8E0"> <!-- sw 5/30/11 -->


    <div id="jquery_jplayer"></div>
    <!-- // ACCESSIBILITY -->
    <a href="index.html#content" ><img src="dot.gif" alt="skip to content" border=0 width=1 height=1></a>
	
	<!-- sw 5/30/11 -->
	<!-- // TOP LOGO AND BANNER -->
	<table width="100%" border=0 cellspacing=0 cellpadding=0>
		<tr> 
			<!--// logo -->

			<td width="1%"><a href="../index.html"><img src="../graphics/logo.gif" alt="" width="275" height="100" border=0></a></td>
			<!--// banner -->
			<td width="99%" valign="top">
				<table width="100%" border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td colspan=2><img src="../dot.gif" alt="" border=0 width=1 height=40></td>
					</tr>
					<tr>
						<td width="90%" align="center" nowrap bgcolor="#009a9a"><font size="+2" color="white" face="Arial, sans-serif"><b><i><span id="pageTitle" /></i></b></font></td>

						<td nowrap bgcolor="#009a9a" align="center"><a href="https://kgnu.org/ht/quickjoin.html"><img src="../graphics/joinnow.gif" alt="Join now!" title="Click to become a KGNU member!" border=0 width=115 height=23 vspace=1></a><br><a href="mailto:&#108;&#105;&#115;&#116;&#101;&#110;&#101;&#114;&#115;&#45;&#115;&#117;&#98;&#115;&#99;&#114;&#105;&#98;&#101;&#64;&#107;&#103;&#110;&#117;&#46;&#111;&#114;&#103;"><img src="../graphics/emailsignup.gif" alt="E-mail sign-up" title="Click to sign up for the KGNU newsletter" border=0 width=115 height=23 vspace=1></a></td>
						<td bgcolor="#009a9a"><img src="../dot.gif" alt="" border=0 width=30 height=54></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
  
    <!-- // LINKS AND CONTENT -->
    <table width="100%" border=0 cellspacing=0 cellpadding=5>
      <tr>

        <td width="1%" valign="top"><!--// LEFT LINKS -->
          <table border=0 cellpadding=0 cellspacing=0>
            <tr>
              <td height="190">
                <a href="/"><img src="../btns/btn1.gif" alt="home" border=0 width=175 height=22 name="btn1" vspace=1></a><br><br>
                <a href="/ht/listencomp.html" onMouseOver="GoIn(2);" onMouseOut="GoOut(2);"><img src="../btns/btn2.gif" alt="listen online" border=0 width=175 height=22 name="btn2" vspace=1></a><br>
                <a onMouseOver="GoIn(3);" onMouseOut="GoOut(3);"><img src="../btns/btn3.gif" alt="archives/playlist" border=0 width=175 height=22 name="btn3" vspace=1></a><br>
                <a href="/ht/support.html" onMouseOver="GoIn(4);" onMouseOut="GoOut(4);"><img src="../btns/btn4.gif" alt="volunteer" border=0 width=175 height=22 name="btn4" vspace=1></a><br>
                <a href="/ht/volunteer.html" onMouseOver="GoIn(5);" onMouseOut="GoOut(5);"><img src="../btns/btn5.gif" alt="buy our stuff" border=0 width=175 height=22 name="btn5" vspace=1></a><br>
                <a href="/ht/buy.html" onMouseOver="GoIn(6);" onMouseOut="GoOut(6);"><img src="../btns/btn6.gif" alt="submit stuff" border=0 width=175 height=22 name="btn6" vspace=1></a><br>
                <a href="/ht/submit.html" onMouseOver="GoIn(7);" onMouseOut="GoOut(7);"><img src="../btns/btn7.gif" alt="contact us" border=0 width=175 height=22 name="btn7" vspace=1></a><br>
                <a href="/ht/contact.html" onMouseOver="GoIn(8);" onMouseOut="GoOut(8);"><img src="../btns/btn8.gif" alt="our shows" border=0 width=175 height=22 name="btn8" vspace=1></a><br>
                <a href="/ht/services.html" onMouseOver="GoIn(9);" onMouseOut="GoOut(9);"><img src="../btns/btn9.gif" alt="our services" border=0 width=175 height=22 name="btn9" vspace=1></a><br>
                <a href="/ht/aboutus.html" onMouseOver="GoIn(10);" onMouseOut="GoOut(10);"><img src="../btns/btn10.gif" alt="about us" border=0 width=175 height=22 name="btn10" vspace=1></a><br>
                <a href="/ht/calendarsonline.html" onMouseOver="GoIn(11);" onMouseOut="GoOut(11);"><img src="../btns/btn11.gif" alt="calendars" border=0 width="175" height="22" name="btn11" vspace=1></a><br><br><img src="http://www.kgnu.org/dot.gif" alt="" width=6 height=1 border=0 align="none">
                <a href="http://www.twitter.com/KGNU" target="_blank"><img src="../graphics/twitter.png" alt="Follow us on Twitter" width="32" height="32" border="0"></a><img src="http://www.kgnu.org/dot.gif" alt="" width=4 height=1 border=0 align="none"><a href="http://www.facebook.com/kgnu.colorado" target="_blank"><img src="../graphics/facebook.png" alt="Facebook" width="32" height="32" border=0></a>
              </td>
            </tr>
          </table>
        </td>


        <td valign="top" align="center" width="100%">
        <!--// contents -->
          
          <a name="content"></a> <!-- accessibility -->
          <table width="100%" border=0 cellspacing=9 cellpadding=0> <!-- // This sets the cellspacing around the 4 boxes -->


<!-- // Tune In -->

                  <!--<tr> 
                    <td>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#867564" valign="top"><img src="music/newbanner/top-left-brown-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#867564"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#867564" valign="top"><img src="music/newbanner/top-right-brown-box.gif" alt="" width=29 height=6 border=0 align="none"></td>

                        </tr>
                      </table>
                      <table width="100%" bgcolor="#867564" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td>
                            <table bgcolor="#867564" border=0 cellspacing=0 cellpadding=0>
                              <tr>
                                <td bgcolor="#867564"><font face="Arial, sans-serif" size="-1" color="#cdc6bb"><font color="4d3c22"><i>&nbsp;&nbsp;&nbsp;Tune In: </i></b><font color="#cdc6bb">88.5 FM & 1390 AM <i>(Denver / Boulder)</i> <font color="4d3c22">// <font color="#cdc6bb">93.7 FM <i>(Nederland)</i> <font color="4d3c22">// <a href="ht/listencomp.html"><font color="#cdc6bb">Online Streams</a></font></center></td>
                                <td bgcolor="#867564"><img src="dot.gif" alt="" width=10 height=1 border=0 align="none"></td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                      </table>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#867564" valign="top"><img src="music/newbanner/btm-left-brown-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#867564"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#867564" valign="top"><img src="music/newbanner/btm-right-brown-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                        </tr>
                      </table>
                    </td>
                  </tr> --> <!-- sw 5/30/11 removed -->

<!-- // End Tune In -->

<!-- // Quick Clicks Box -->

                  <!--<tr> 
                    <td>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="music/newbanner/top-left-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#DFDCD7"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="music/newbanner/top-right-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>

                        </tr>
                      </table>
                      <table width="100%" bgcolor="#DFDCD7" border=0 cellspacing=0 cellpadding=0>
                        <tr>
          <td valign="top">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td valign="top">
                  <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                <td bgcolor="DFDCD7" valign="top"><img src="music/newbanner/quick-click-top.gif" width="71" height="23"></td>
                <td bgcolor="DFDCD7" valign="top"><a href="http://www.kgnu.org"><img src="music/earbud/mu-img/ql-home.gif" width="47" height="23" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="https://kgnu.org/ht/quickjoin.html"><img src="music/earbud/mu-img/ql-donate.gif" width="51" height="23" border="0"></a></td>

                <td bgcolor="DFDCD7" valign="top"><a href="http://playlist.kgnu.net/"><img src="music/earbud/mu-img/ql-playlist.gif" width="52" height="23" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="ht/schedule.html"><img src="music/earbud/mu-img/ql-schedule.gif" width="61" height="23" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="ht/listings.html"><img src="music/earbud/mu-img/ql-archives.gif" width="60" height="23" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="ht/volunteer.html"><img src="music/earbud/mu-img/ql-volunteer.gif" width="64" height="23" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="ht/contact.html"><img src="music/earbud/mu-img/ql-contact.gif" width="57" height="23" border="0"></a></td>
              </tr>
            </table>  
          </td>
                <td valign="top" rowspan="2" bgcolor="#DFDCD7"><img src="dot.gif" alt="" width=11 height=1 border=0 align="none"></td>
                <td valign="top" rowspan="2"><a href="http://www.twitter.com/KGNU" target="_blank"><img src="music/earbud/mu-img/ql-twitter-new-sm.gif" width="27" height="45" border="0"></a>
                <td valign="top" rowspan="2" bgcolor="#DFDCD7"><img src="dot.gif" alt="" width=6 height=1 border=0 align="none"></td>
                <td valign="top" rowspan="2"><a href="http://www.facebook.com/kgnu.colorado" target="_blank"><img src="music/earbud/mu-img/ql-facebook-new-sm.gif" width="27" height="45" border="0"></a>
                </td>

        </tr>
        <tr>
          <td valign="top">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td bgcolor="DFDCD7" valign="top"><img src="music/newbanner/quick-click-btm.gif" width="71" height="22"></td>
                <td bgcolor="DFDCD7" valign="top"><a href="http://stream.kgnu.net:8000/KGNU_live_high.mp3.m3u"><img src="music/earbud/mu-img/ql-mp3-high.gif" width="105" height="22" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="http://stream.kgnu.net:8000/KGNU_live_med.mp3.m3u"><img src="music/earbud/mu-img/ql-mp3-medium.gif" width="119" height="22" border="0"></a></td>

                <td bgcolor="DFDCD7" valign="top"><a href="http://stream.kgnu.net:8000/KGNU_live_low.mp3.m3u"><img src="music/earbud/mu-img/ql-mp3-low.gif" width="101" height="22" border="0"></a></td>
                <td bgcolor="DFDCD7" valign="top"><a href="ht/listencomp.html"><img src="music/earbud/mu-img/ql-more-streams.gif" width="88" height="22" border="0"></a></td>
                    </tr>
                  </table>  
                </td>
              </tr>
            </table>  
          </td>
                        </tr>

                      </table>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="music/newbanner/btm-left-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#DFDCD7"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="music/newbanner/btm-right-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                        </tr>
                      </table>
                    </td>
                  </tr> --> <!-- sw 5/30/11 removed -->

<!-- // End Quick Clicks Box -->                                    

                  
<!-- //  Volunteer Box -->

                  <!-- // <tr> 
                    <td>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="http://www.kgnu.org/music/newbanner/top-left-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#DFDCD7"><img src="http://www.kgnu.org/dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="http://www.kgnu.org/music/newbanner/top-right-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>

                        </tr>
                      </table>
                      <table width="100%" bgcolor="#DFDCD7" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td>
                            <table bgcolor="#DFDCD7" border=0 cellspacing=0 cellpadding=0>
                              <tr>
                                <td bgcolor="#DFDCD7"><img src="http://www.kgnu.org/dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                                <td width=29 bgcolor="#DFDCD7" ><img src="http://www.kgnu.org/music/newbanner/tan-vol-gradient-left.gif" alt="" height=60 border=0></td>

                                <td bgcolor="#DFDCD7"><img src="http://www.kgnu.org/images/banner/banner-D-tan.jpg" alt="" height=60 border=0></td>
                                <td bgcolor="#DFDCD7"><img src="http://www.kgnu.org/music/newbanner/tan-vol-gradient-right.gif" alt="" height=60 border=0></td>
                                <td bgcolor="#DFDCD7"><font face="Arial, sans-serif" size="-1" color="#867564"><i>This station runs on <a href="http://www.kgnu.org/ht/volunteer.html"><font color="e09e20">volunteer</font></a><font color="#867564"> power and participation from the community.</i></td>
                                <td bgcolor="#DFDCD7"><img src="http://www.kgnu.org/dot.gif" alt="" width=10 height=1 border=0 align="none"></td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                      </table>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="http://www.kgnu.org/music/newbanner/btm-left-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#DFDCD7"><img src="http://www.kgnu.org/dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#DFDCD7" valign="top"><img src="http://www.kgnu.org/music/newbanner/btm-right-sand-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>--> 

<!-- // End Volunteer Box -->                                    

<!-- // Begin Membership Box -->
                                  
                  <!--<tr> 
                    <td>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#b9dc60" valign="top"><img src="music/newbanner/top-left-green-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#b9dc60"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#b9dc60" valign="top"><img src="music/newbanner/top-right-green-box.gif" alt="" width=29 height=6 border=0 align="none"></td>

                        </tr>
                      </table>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td>
                            <table bgcolor="#b9dc60" border=0 cellspacing=1 cellpadding=5>
                              <tr>
                                <td bgcolor="#b9dc60"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                                <td width=29 bgcolor="#badc60" ><a href="https://kgnu.org/ht/quickjoin.html"><img src="music/newbanner/green-donate-button.gif" alt="" width=60 height=60 border=0></a></td>

                                <td bgcolor="#e3ec94">
                                <font face="Arial, sans-serif" size="+1" color="ce920d">
                              <center><b>Support Independent Community Radio<br></b></center></font>
                            
                            
                              <font face="Arial, sans-serif" size="-1" color="2f302f"><b>KGNU is independent, non-commercial, community radio for Boulder, Denver and beyond. We depend on listener donations to keep the radio station running. Please <a href="https://kgnu.org/ht/quickjoin.html"><font color="4a7e27">make a donation now</font></a>. Let us hear from you!</b></font><br>
                              <font face="Arial, sans-serif" size="-5" color="7dc0c1"><font face="Arial, sans-serif" size="-1" color="8cd9d8">&nbsp;</font></font>
                                </td>
                                <td bgcolor="#b9dc60"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                      </table>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>
                        <tr>
                          <td width=29 bgcolor="#b9dc60" valign="top"><img src="music/newbanner/btm-left-green-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                          <td colspan="2" bgcolor="#b9dc60"><img src="dot.gif" alt="" width=1 height=1 border=0 align="none"></td>
                          <td width=29 bgcolor="#b9dc60" valign="top"><img src="music/newbanner/btm-right-green-box.gif" alt="" width=29 height=6 border=0 align="none"></td>
                        </tr>
                      </table>
                    </td>
                  </tr> --> <!-- sw 5/30/11 removed -->

                  <tr> 
                    <td>
                      <table width="100%" border=0 cellspacing=0 cellpadding=0>

                        <tr>
                          <td width="0%"><img src="dot.gif" alt="" width=1 height=1 border=0></td>
                          <td width="100%"><img src="dot.gif" alt="" width=1 height=1 border=0></td>
                          <td width="0%"><img src="dot.gif" alt="" width=1 height=1 border=0></td>
                          <td width="0%"><img src="dot.gif" alt="" width=1 height=1 border=0></td>
                          <td width="0%"><img src="dot.gif" alt="" width=1 height=1 border=0></td>
                        </tr>

                        


                        <tr> <!-- // Box bottoms -->

                          <!-- // Box bottom for center-left box -->
                          <td colspan=5 bgcolor="white">
                            <table width="100%" border=0 cellspacing=0 cellpadding=0 style="border-top:1px solid #cccc99">

                              <tr>


                          <!-- // Box sides and content for center-left box -->
                          <!-- right edge of box -->
                          <td width=1 bgcolor="#cccc99"><img src="dot.gif" alt="" width=1 height=1 border=0></td>
                          <!-- contents -->
                          <td valign="top" bgcolor="white">
                            <table width="100%" border=0 cellspacing=30 cellpadding=0> <!-- // this cellspacing sets the indent between the card edges and its content -->
                              <tr>
                                <td>
                                  <!-- // CENTER-LEFT BOX INNER CONTENT -->
                                  <table width="100%" border=0 cellspacing=0 cellpadding=0>
                                    <tr> <!--//<{Start}>|Spotlight|-->
                                      <td><img src="dot.gif" alt="" width=1 height=5 border=0></td>
                                    </tr>
                                    <tr>
                                      <td valign="top" bgcolor="white">
