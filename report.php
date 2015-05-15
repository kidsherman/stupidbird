<html>
<meta name="viewport" content="target-densitydpi=device-dpi,width=640,user-scalable=no" />

<table border="1" width="600" frame="hsides" rules="groups">
     <caption>今 日 报 表</caption>
     <colgroup span="1" width="200"></colgroup>
     <colgroup span="6" width="400"></colgroup>

<thead>
     <tr>
          <td bgcolor="#CC9999">类 别</td>
          <td bgcolor="#CC9999">品 牌</td>
          <td bgcolor="#CC9999">型 号</td>
          <td bgcolor="#CC9999">颜 色</td>
          <td bgcolor="#CC9999">客 户</td>
          <td bgcolor="#CC9999">销售人</td>
     </tr>
</thead>

<?php
$con=mysqli_connect("stupidbird.gotoftp5.com","stupidbird","chuntian123","stupidbird");
mysql_query("SET NAMES 'UTF8'");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"select '手机' AS  'class',b.product_brand as 'brand',b.product_type as 'type',b.product_color as 'color',c.name as 'customer',a.user as 'user' from sales a,deal b,customer c where a.deal_id=b.id and a.customer_id=c.id");

echo "<tbody>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td >" . $row['class'] . "</td>";
  echo "<td >" . $row['brand'] . "</td>";
  echo "<td >" . $row['type'] . "</td>";
  echo "<td > " . $row['color'] . "</td>";
  echo "<td > " . $row['customer'] . "</td>";
 echo "<td > " . $row['user'] . "</td>";
  echo "</tr>";
}

mysqli_close($con);

echo "</tbody>"

?>



</table>
</html>
