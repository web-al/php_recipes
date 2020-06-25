/* $row2 = mysqli_fetch_array($response);
echo "<table border='1'>";
	echo "<tr>";
		echo "<td>Ingredient</td>";
		echo "<td>Amount</td>";
		echo "<td>Measurement unit</td>";
	echo "</tr>";

while($row2 = mysqli_fetch_array($response))
	{
		echo "<tr>";
		echo "<td>".$row2["ingredient_name"]."</td>";
		echo $row2["amount"];
		echo $row2["measurement_name"];
	}
echo "</table>"; */
