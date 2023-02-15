<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
 
  function searchdata() {
    
    let sid = document.getElementById('search_sid').value;
    let fname = document.getElementById('search_fname').value;
    let lname = document.getElementById('search_lname').value;
    let birthplace = document.getElementById('search_birthplace').value;
    let birthDate = document.getElementById('search_birthDate').value;
    // console.log(fname);
    let degisken = new XMLHttpRequest();
    degisken.open("GET","function.php?sid="+sid+"&fname="+fname+"&lname="+lname+"&birthplace="+birthplace+"&birthDate="+birthDate+"&action=search");
    degisken.onload = function(){
      response= this.responseText;
      if (response) {
        document.getElementById('body').innerHTML =response;

        } else {
         // $("#body").html(response);
         
          alert("Sonuç Bulunamadı");
          //sayfalama($conn, 1);
        }
    }
    degisken.send();
  }

  function yeni() {
    if (document.getElementById('yeni').style.display == 'none') {
      var result_style = document.getElementById('yeni').style;
      result_style.display = '';

    } else {
      var result_style = document.getElementById('yeni').style;
      result_style.display = 'none';
    }
  }


  function deletedata(sid) {

    let degisken = new XMLHttpRequest();
    degisken.open("GET","function.php?sid="+sid+"&action=delete");
    degisken.onload = function(){
      response= this.responseText;
      if (response) {
          alert("Data Deleted Successfully");
           document.getElementById(sid).style.display = "none";
         } else {
           alert("Data Cannot Be Deleted");
         }
    }
    degisken.send();

  }

  function insertdata() {

    let id= document.getElementById('id').value;
    let first_name = document.getElementById('first_name').value;
    let last_name = document.getElementById('last_name').value;
    let birth_place = document.getElementById('birth_place').value;
    let birth_date = document.getElementById('birth_date').value;

    let degisken = new XMLHttpRequest();
    degisken.open("GET","function.php?sid="+id+"&fname="+first_name+"&lname="+last_name+"&birthplace="+birth_place+"&birthDate="+birth_date+"&dataType="+'json'+"&action=insert");
    degisken.onload = function(){
    response= this.responseText;
  //var response=JSON.parse(response);
      
     // if (response[0] == 1) {
        
        alert("Data Inserted Successfully");
     
        // document.getElementById(sid).style.display = "none";
        var table = document.getElementById("TABLE");
        var row = table.insertRow();
        row.setAttribute('id', response);

        var cell = row.insertCell();
        cell.innerHTML = response;
        cell.setAttribute('id',response);

        var cell = row.insertCell();
        cell.innerHTML = first_name;
        cell.setAttribute('id',first_name+response);

        var cell = row.insertCell();
        cell.innerHTML = last_name;
        cell.setAttribute('id',last_name+response);


        var cell = row.insertCell();
        cell.innerHTML = birth_place;
        cell.setAttribute('id',birth_place+response);

        var cell = row.insertCell();
        cell.innerHTML = birth_date;
        cell.setAttribute('id',birth_date+response);

        var cell = row.insertCell();
        cell.innerHTML = "<button type='button' name='button' onclick = 'deletedata(" + response[1] + ")'>SİL</button>";

        var cell = row.insertCell();
        var temp = response + ",\"" + first_name + "\"" + ",\"" + last_name + "\"" + ",\"" + birth_place + "\"" + ",\"" + birth_date + "\"";
        console.log(temp);
        cell.innerHTML = "<button class='btn btn-secondary' id='edit' value='edit' onclick = 'updatedata("+temp+")'>GÜNCELLE</button>";
        cell.setAttribute('id','updateCell'+response);

    //  cell.innerHTML = "<button type='button' name='button' onclick = 'updatedata(" + id + ")'>GÜNCELLE</button>";
      //} else if (response == 0) {
        //alert("Data Cannot Be Inserted");
      //}
    }
    degisken.send();


  }

  function updatedata(sid, fname, lname, birthplace, birthDate) {
    console.log(sid+fname+lname+birthplace+birthDate); 

    //document.getElementById('0'+sid).innerHTML = "<input type='text' class='table' id='sid1' value="+sid+">";
    document.getElementById(fname+sid).innerHTML = "<input style='heigth:100%' type='text' class='table' id='fname1' value=" + fname + ">";
    document.getElementById(lname+sid).innerHTML = "<input type='text' class='table' id='lname1' value=" + lname + ">";
    document.getElementById(birthplace+sid).innerHTML = "<input type='text' class='table' id='birthplace1' value=" + birthplace + ">";
    document.getElementById(birthDate+sid).innerHTML = "<input type='text' class='table' id='birthDate1' value=" + birthDate + ">";
    document.getElementById('updateCell' + sid).innerHTML = "<button type='button' class='btn btn-success save' value='save' id='save' onclick='savedata(" + sid +
      "," + "\"" + fname + "\"" + "," + "\"" + lname + "\"" + "," + "\"" + birthplace + "\"" + "," + "\"" + birthDate + "\"" + ")' >SAKLA</button>";
  }

  function savedata(sid_old, fname_old, lname_old, birthplace_old, birthDate_old) {

    let id = sid_old;
    let fname = document.getElementById('fname1').value;
    let lname = document.getElementById('lname1').value;
    let birthplace = document.getElementById('birthplace1').value;
    let birthDate = document.getElementById('birthDate1').value;

    let degisken = new XMLHttpRequest();
    degisken.open("GET","function.php?sid="+id+"&fname="+fname+"&lname="+lname+"&birthplace="+birthplace+"&birthDate="+birthDate+"&action=update")
    degisken.onload = function(){
    response= this.responseText;
      if (response) {
          document.getElementById(fname_old+id).id = fname+id;
          document.getElementById(lname_old+id).id = lname+id;
          document.getElementById(birthplace_old+id).id = birthplace+id;
          document.getElementById(birthDate_old+id).id = birthDate+id;
          document.getElementById('updateCell' + id).innerHTML = "<button class='btn btn-secondary' id='edit' value='edit' onclick='updatedata(" + id +
            "," + "\"" + fname + "\"" + "," + "\"" + lname + "\"" + "," + "\"" + birthplace + "\"" + "," + "\"" + birthDate + "\"" + ")'>GÜNCELLE</button>";

          document.getElementById(fname+id).innerHTML = fname;
          document.getElementById(lname+id).innerHTML = lname;
          document.getElementById(birthplace+id).innerHTML = birthplace;
          document.getElementById(birthDate+id).innerHTML = birthDate;

        } else{
          console.log("fail");
        }
    }
    degisken.send()

  }
</script>
