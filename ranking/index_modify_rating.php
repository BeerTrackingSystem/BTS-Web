<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>

<table id='modifyrating' border='0'>
<tr><td><br><h3 style='display:inline;'>Modify your ratings</h3></td></tr>
<tr>
	<td>
        	<table border='1'>
		<tr>
			<td valign="top">
                        	<form action="./change_ratings.php" method="post">
				Select the desired beer and insert your rating.<br>
				Blank rating = delete rating:
	                        <br><br>
                                <table>
                                <tr>
                                	Brewery:
                                        <select name='brewery' id='brewery'>
                                                <option value="blank" selected>Select brewery</option>
                                                <?php
                                                        $querygetbreweries = "SELECT breweries.id as breweryid, breweries.name as brewery FROM breweries ORDER BY brewery ASC;";
                                                        $resultgetbreweries = mysqli_query($db, $querygetbreweries);

                                                        while($row = mysqli_fetch_array($resultgetbreweries))
                                                        {
                                                                echo "<option value='" . $row['breweryid'] . "'>" . $row['brewery'] . "</option>";
                                                        }
                                                ?>
                                        </select>
                                </tr>
                                <br><br>
                                <tr>
                                        Beers:
                                        <select name='beer' id='beer'>
                                                <option value="blank" selected>Select brewery first</option>
                                        </select>
                                </tr>
                                <br><br>
                                <tr>
                                        <td colspan='2'>
						<?php
							$querygetminmaxrate = "SELECT value AS min_rate, (SELECT value AS max_rate FROM misc WHERE object = 'beer_rank' AND attribute = 'max_rate') AS max_rate FROM misc WHERE object = 'beer_rank' AND attribute = 'min_rate';";
                                                        $resultgetminmaxrate = mysqli_query($db, $querygetminmaxrate);
							$minmax_rate = mysqli_fetch_array($resultgetminmaxrate);
						?>
							<input type='number' name='rating' min='<?php echo $minmax_rate['min_rate'] ?>' max='<?php echo $minmax_rate['max_rate'] ?>' style='width: 50px;'>
                                                <input type='submit' value='Submit'>
                                        </td>
                                </tr>
				</table>
                        	</form>
                	</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<script>
  $(document).ready(function(){
    $('#brewery').on('change',function(){
      getbeer();
    });

    function getbeer(){
      var breweryid = $('#brewery').val();

      $.ajax({
          type:'POST',
          url:'getbeers.php',
          data:'breweryid='+breweryid,
          success:function(data){
            $('#beer').html(data);
          }
      });
      }; 
  });
</script>
