<?php
require_once 'pdf/vendor/../autoload.php';

$mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'sarabun'
]);

  include "path/connectpdo.php";

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
                          <th>รูปภาพ</th>
                          <th>ชื่อสินค้า</th>
                          <th>จำนวน</th>
                          <th>ราคา</th>
                    </tr>";
        $i = 0;
   
        $sql = "SELECT *,SUM(price) as sum FROM `cart` WHERE sUBSTRING(date, 1, 7) LIKE '%2020-10%'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $product_id = $row['product_id'];
            $amount = $row['amount'];
            $price = $row['price'];
            $sum = $row['sum'];

            $sql1 = "SELECT *,SUM(pro_quantity) as sum1 FROM product WHERE pro_type = :product_id";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindparam(':product_id', $product_id);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                $pro_id = $row1['pro_id'];
                $pro_name = $row1['pro_name'];
                $pro_quantity = $row1['pro_quantity'];
                $pro_price = $row1['pro_price'];
                $pro_img = $row1['pro_img'];
                $sum1 = $row1['sum1'];
            $i++;

    $html .= "  <tr>
                    <td align='center'>".$i."</td>
                    <td align='center'><img src='img/".$pro_img."' style='width: 100px; height: 100px'></td>                     
                    <td align='center'>".$pro_name."</td>
                    <td align='center'>".$amount."</td>
                    <td align='center'>".$price."</td>
                </tr>";
}
$html .= "
          <tr>
              <td colspan='4' style='text-align: right;'><b>ยอดขายทั้งหมด :</b></td>
              <td style='text-align: right;'><b>".$sum." บาท</b></td>
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