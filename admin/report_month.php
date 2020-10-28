<?php
require_once 'pdf/vendor/../autoload.php';

$mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'sarabun'
]);

  include "path/connectpdo.php";
  include "path/connect.php";

$months = $_POST['month'];

$sub = substr($months,0,7);

function DateThai($months){
    $year = date("Y",strtotime($months))+543;
    $month= date("n",strtotime($months));
    $day= date("j",strtotime($months));
    $monthcut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
    $monththai=$monthcut[$month];
    return "$day $monththai $year";
}  

$html = "<h3 style='text-align: center;'>รายงานยอดขายประจำเดือน ".DateThai($months);"</h3><hr>";
             
$html .= "<br><br><br><table>
                    <tr>
                          <th>ลำดับ</th>
                          <th>ชื่อสินค้า</th>
                          <th>จำนวน</th>
                          <th>ราคา</th>
                    </tr>";

            $someArray = [];
            $i = 0;
            $query = "SELECT list,SUM(price) as test FROM invoice WHERE SUBSTRING(create_at, 1, 7) LIKE '".$sub."'";
            $result = $conn->query($query);
            $row5 = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $test = $row5['test'];

            $user = json_decode($row5['list'], true);

            foreach($user['cart_id'] as $key => $cart_id){
                $someArray[$i] = $cart_id;
                $i = $i+1;
            }
            $yy = 0;
  
                $sql1 = "SELECT *,SUM(amount) as yu FROM cart WHERE SUBSTRING(date, 1, 7) LIKE '".$sub."' GROUP BY product_id";
                $stmt1 = $db->prepare($sql1);
                $stmt1->execute();
                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row1['id'];
                    $yu = $row1['yu'];
                    $product_id = $row1['product_id'];
                    $sum  = $row1['sum'];
                    $amount  = $row1['amount'];

                    $sql4= "SELECT *,SUM(amount) as rr FROM cart WHERE SUBSTRING(date, 1, 7) LIKE '".$sub."'";
                    $stmt4 = $db->prepare($sql4);
                    $stmt4->execute();
                    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                        $rr = $row4['rr'];
                
                $sql = "SELECT * FROM product WHERE pro_id = '".$product_id."'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $pro_id = $row['pro_id'];
                    $pro_price  = $row['pro_price'];
                    $pro_name = $row['pro_name']; 
                    $pro_img = $row['pro_img']; 

                    $value = $yu * $pro_price;
   
                
            $yy++;

    $html .= "  <tr>
                    <td align='center'>".$yy."</td>                  
                    <td align='center'>".$pro_name."</td>
                    <td align='center'>".$yu."</td>
                    <td align='center'>".$value."</td>
                </tr>";
}
$html .= "
          <tr>
              <td colspan='3' style='text-align: right;'><b>ยอดขายทั้งหมด :</b></td>
              <td style='text-align: right;'><b>".$test." บาท</b></td>
          </tr>
          <tr>
          <td colspan='3' style='text-align: right;'><b>จำนวนที่ขายได้ทั้งหมด :</b></td>
          <td style='text-align: right;'><b>".$rr." ชิ้น</b></td>
      </tr>";
        
                
        

$html .= "</table>";
$html .= "<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: center;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 2px;
}
</style>";
$mpdf->WriteHTML($html);
$mpdf->Output();
?>