<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
    <title>Kalamazoo ACS</title>
    <?php include 'base.php' ?>
    <meta name="description" content="We are a dynamic and visionary organization committed to improving people&rsquo;s lives in our community through the transforming power of chemistry.  We strive to advance the broader chemistry enterprise and its practitioners for the benefit of Kalamazoo, Allegan and Van Buren counties." />

    <!-- Favicon -->
    <link rel="shortcut icon"
	  href="favicon.ico" />

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/bjqs/bjqs.css" />
    <link rel="stylesheet" type="text/css" href="assets/kacs.css" />
    <style type="text/css">
    .titletext {
	color: #036;
    }
    .titletext {
	color: #2A4370;
    }
    .titletext font .titletext {
	color: #2D497D;
    }
    .titletext font {
	color: #344D91;
    }
    .titletext {
	color: #FFF;
    }
    .titletext font {
	color: #FFF;
    }
    .DarkRed {
	color: #671819;
    }
    </style>

    <!-- Javascript -->
    <script type="text/javascript"
	    src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="assets/bjqs/js/bjqs-1.3.min.js"></script>

    <script type="text/javascript">

      // Google analytics
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23162633-1']);
      _gaq.push(['_trackPageview']);

      (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

      // Slideshow animation
      var anim_dur = 1000; // in milliseconds
      var interval = 4000; // milliseconds between transitions
      function slideSwitch() {
	  var $active = $('.slideshow img.active');

	  if ( $active.length == 0 ) $active = $('.slideshow img:last');

	  var $next = $active.next().length ? $active.next()
	      : $('.slideshow img:first');

	  $active.addClass('last-active');

	  // Fade in the new image
	  // $next.css({opacity: 0.0})
	  $next.addClass('active')
	      // .animate({opacity: 1.0}, anim_dur, function() {
	      .fadeIn(anim_dur, function() {
		  $active.removeClass('active last-active');
	      });
	  // Fade out the old image
	  $active.fadeOut(anim_dur);
	  // $active.animate({opacity: 0.0}, anim_dur);

      }

      $(document).ready( function() {
	  // Set up donor logo slideshow
	  $('#slideshow').addClass('slideshow');
	  slideSwitch();
	  setInterval( "slideSwitch()", interval );

      $('#dance-photos').bjqs({
        'height' : 370,
        'width' : 584,
        'responsive' : true,
      'animtype': 'slide',
    });
      });

    </script>
  </head>

  <!-- <body> -->
  <!--   <div class="row header"> -->
  <!--     <div class="col-sm-9"> -->
  <!-- 	<h1 class="logo"> -->
  <!-- 	  KACS -->
  <!-- 	</h1> -->
  <!-- 	<h2 class="subtitle"> -->
  <!-- 	  Kalamazoo Section of the American Chemical Society -->
  <!-- 	</h2> -->
  <!--     </div> -->
  <!--     <div class="col-sm-3"> -->
  <!-- 	<img src="images/ACSlogo_August_2011.jpg"> -->
  <!--     </div> -->
  <!--   </div> -->

  <body>
    <table width="850" border="0" cellspacing="2" cellpadding="0">
      <tr>
	<td colspan="3" bgcolor="#FFFFFF">
	  <table width="100%" border="0" cellpadding="7" cellspacing="0">
	    <tr>
	      <td valign="middle" bgcolor="#003366">
		<p>
		  <font color="#6699cc" size="7" face="Trebuchet MS, Geneva, Arial, Helvetica, SunSans-Regular, sans-serif" class="titletext">
		    <a href="" class="titletext logo">KACS</a>
		  </font>
		  <span class="titletext">
		    <span class="titletext">
		      <font size="4" color="#6699cc" face="Trebuchet MS, Geneva, Arial, Helvetica, SunSans-Regular, sans-serif"><br>
		      </font>
		    </span>
		    <font size="4" color="#6699cc" face="Trebuchet MS, Geneva, Arial, Helvetica, SunSans-Regular, sans-serif">
		      Kalamazoo Section of the American Chemical Society
		    </font>
		  </span>
		</p>
	      </td>
	      <td align="right" valign="middle" bgcolor="#003366">
		<span class="titletext">
		  <font size="4" color="#6699cc" face="Trebuchet MS, Geneva, Arial, Helvetica, SunSans-Regular, sans-serif">
		    <font size="4" color="#6699cc" face="Trebuchet MS, Geneva, Arial, Helvetica, SunSans-Regular, sans-serif">
		      <a href=""><img src="images/ACSlogo_August_2011.jpg" width="209" height="88" align="absbottom"></a>
		    </font>
		  </font>
		</span>
	      </td>
	    </tr>
	  </table>
	</td>
      </tr>
