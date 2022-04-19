<?php
        define('index_origin', true);
        include '../db.inc.php';
        include '../check_login.php';
	$sessionid=$_COOKIE['PHPSESSID'];
?>
<?php
	$querymisc = "SELECT attribute,value FROM misc WHERE object = 'ranking_page' AND (attribute = 'title' OR attribute = 'heading');";
        $resultmisc = mysqli_query($db, $querymisc);

        while ($row = $resultmisc->fetch_assoc()) {
                if ($row['attribute'] == 'title')
                {
                        $title = $row['value'];
                }
                if ($row['attribute'] == 'heading')
                {
                        $heading = $row['value'];
                }
	}
?>
<html>
<head>
<script src="../packages/jquery.min.js"></script>
        <title><?php echo htmlspecialchars($title); ?></title>

<script>
$(document).ready(function(){
    $("#modifyrating").show();
    $("#ratingsbybrewery").hide();
    $("#ratingsbyuser").hide();
    $("#ratingsbybeer").hide();
  $("#show-modify").click(function(){
    $("#modifyrating").toggle();
  });
  $("#show-rbb").click(function(){
    $("#ratingsbybrewery").toggle();
  });
  $("#show-rbu").click(function(){
    $("#ratingsbyuser").toggle();
  });
  $("#show-rbbeer").click(function(){
    $("#ratingsbybeer").toggle();
  });
});
</script>
</head>
<body>
	<center><h1><?php echo $heading; ?></h1></center>
	<?php
		if (check_login($sessionid)[0] && check_login($sessionid)[1] == '0')
                                {
					echo "<button id='show-modify'>Add, Delete or Modify your ratings</button> ";
                                }
		echo "<button id='show-rbb'>Ratings by Brewery</button> ";
		echo "<button id='show-rbu'>Ratings by User</button> ";
		echo "<button id='show-rbbeer'>Ratings by Beer</button> ";
		if (check_login($sessionid)[0] && check_login($sessionid)[1] == '0')
                                {
					include 'index_modify_rating.php';
                                }
		include 'beer_rating_by_brewery.php';
		include 'beer_rating_by_user.php';
		include 'beer_rating_by_beer.php';
	?>
</body>
</html>
