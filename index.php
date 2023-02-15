<?php

include 'config.php';
require 'script.php';

pageHeader();
listele($conn); 
pageBottom();
$conn->close();
exit;

function pageHeader(){
    echo <<< pageHeader

    <html>
    <head>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

     <style>

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table{

            width: 60%;
            height: 15%;
            margin-top:10%;
            margin-left: auto;
            margin-right: auto;
            font-size: 1.5em;

        }

        .table{

            
            width: 100%;
            height: 15%;
            font-size: 0.85em;
       

        }

        th,td{
            margin-right:0%;
        }

        #sayfalama{
            text-align:center;
            font-size: 1.5em;
        }

        </style>
      
    </head>

         <body>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
         

    pageHeader;
}

function pageBottom(){
    echo <<< pageBottom

   
    </body>
    </html>

    pageBottom;
}

function listele($conn){

    $num_per_page=5;

    if(isset($_GET["page"]))
    {
        $page=$_GET["page"];

    }
    else{
        $page=1;
    }


    $start_from=($page-1)*5;
    $sql= "SELECT * FROM student";

  
    $result = $conn->query($sql);
    $total_records=mysqli_num_rows($result);
    $total_pages=ceil($total_records/$num_per_page);

    if(isset($_GET['order'])){
        $order = $_GET['order'];
    
    }
    else{
        $order = 'sid';
    }

    @$sort = $_GET['sort']=="ASC" ? "DESC" : "ASC";
    if(isset($_GET['sirala']))
    {
       $sort = $_GET['sirala']=="ASC" ? "ASC" : "DESC";
    }
    
    
    $sql2= "SELECT * FROM student ORDER BY $order $sort LIMIT $start_from,$num_per_page ";
    
    $result2 = $conn->query($sql2);
        

            echo "<table id='TABLE'><tr>
            <th><a href='?page=$page&order=sid&sort=$sort'>No</th>
            <th><a href='?page=$page&order=fname&sort=$sort'>Ad</th>
            <th><a href='?page=$page&order=lname&sort=$sort'>Soyad</th>
            <th><a href='?page=$page&order=birthplace&sort=$sort'>Doğum Yeri</th>
            <th><a href='?page=$page&order=birthDate&sort=$sort'>Doğum Tarihi</th>
            <th><button type='button' name='button' onclick='yeni()'>Yeni</button></th>
            <th>Güncelle</th>
            </tr>
            <tr><td><input type='number' id='search_sid' value=''></td>
            <td><input type='text' id='search_fname' value=''></td>
            <td><input type='text' id='search_lname' value=''></td>
            <td><input type='text' id='search_birthplace' value=''></td>
            <td><input type='text' id='search_birthDate' value=''></td>
            <td><button type='button' id='araButon' onclick='searchdata()'>ARA</button></td>
            </tr>
            <tr id='yeni' style='display:none;'><td><input type='number' id='id' style='display:none;' value=''></td>
            <td><input type='text' id='first_name' value=''></td>
            <td><input type='text' id='last_name' value=''></td>
            <td><input type='text' id='birth_place' value=''></td>
            <td><input type='date' id='birth_date' value=''></td>
            <td><button type='button' name='button' onclick='insertdata()'>OLUŞTUR</button></td>
            </tr>
            <tbody id=body>";
          
           

            while($row = mysqli_fetch_assoc($result2)) {
                
                echo "<tr id=$row[sid]>
                <td id='0$row[sid]'>".$row["sid"]."</td>
                <td id='$row[fname]$row[sid]'>".$row["fname"]."</td>
                <td id='$row[lname]$row[sid]'> ".$row["lname"]."</td>
                <td id='$row[birthplace]$row[sid]'>".$row["birthplace"]."</td>
                <td id='$row[birthDate]$row[sid]'>".$row["birthDate"]."</td>
                <td> 
                <button type='button' name='button' onclick = 'deletedata(".$row['sid'].")'>SİL</button>
                </td>
                              
                <td id='updateCell$row[sid]'>
                    <button class='btn btn-secondary' id='edit' value='edit' 
                    onclick='updatedata(".$row['sid'].","."\"".$row['fname']."\"".",
                    "."\"".$row['lname']."\"".","."\"".$row['birthplace']."\"".","."\"".$row['birthDate']."\"".")'
                    >GÜNCELLE
                    </button>
                </td>
                
                </tr>";
                
                
            } 

            
        echo "</tbody>
        </table>";
        //sayfalama($conn,$total_records);
            

        echo "<div id='sayfalama'>";

            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

            if($page!= 1) echo ' <a href="?page=1">&lt;&lt; </a> ';
                else echo "&lt;&lt";
            if($page!= 1) echo ' <a href="?page='.($page-1).'">&lt; </a> ';
                else echo " &lt";

            for($i=1; $i<=$total_pages; $i++){
                echo $page==$i ?$i." ":"<a  href='index.php?page=".$i."&order=".$order."&sirala=".$sort."'>".$i."</a>";
            }
            
            if($page !=$total_pages) echo ' <a href="?page='.($page+1).'">&gt; </a> ';
                else echo " &gt";
            if($page !=$total_pages) echo ' <a href="?page='.$total_pages.'">&gt;&gt; </a> ';
                else echo " &gt;&gt";
           
        "</div>";

    

}
?>