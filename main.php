<!DOCTYPE html>
<html lang=en>
<head>
     <title>LAB 9</title>
     <meta charset="utf-8">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
</head>
<body>
     <h1 style="margin:50px 0px 50px 600px; padding: auto;">LAB 9</h1>
     <div class="container">
          <table class="table">
               <div id="msg"></div>
               <div id="data"></div>
          </table>
     </div>
</body>
</html>
<script>
$(document).ready(function(){
     var listItem;
     function getData() {
          $.ajax({
               url: "http://localhost/cau2/api/test_api.php",
               method:"GET",
               success:function(data) {
                    listItem = JSON.parse(data);
                    console.log(listItem);
                    $("#data").append('<table class="table table-bordered"><thead class="thead-dark"><tr>'
                    + '<th width="20%" scope="col">ID</th>'
                    + '<th width="30%" scope="col">NAME</th>'
                    + '<th width="30%" scope="col">YEAR</th>'
                    + '<th width="20%" scope="col">HANDLE</th></tr></thead>');
                    for (let i = 0; i < listItem.length; i++) {
                         $(".table-bordered").append('<tbody><th scope="row">' + listItem[i]["id"] + '</th>' 
                         + '<td class="name-result" data-name="'+ listItem[i]["id"] + '" contenteditable>' + listItem[i]["name"] + '</td>'
                         + '<td class="year-result" data-year="' + listItem[i]["id"] + '" contenteditable>' + listItem[i]["year"] + '</td>'
                         + '<td><button type="button" name="btn_delete" data-id="' + listItem[i]["id"] + '" class="btn btn-primary btn_delete">DELETE</button></td>');
                    }
                    $(".table-bordered").append('<tbody><th id="id_insert" scope="row" contenteditable></th>' + 
                    '<td id="name_insert" contenteditable></td>' +
                    '<td id="year_insert" contenteditable></td>' +
                    '<td><button type="button" id="btn_insert" class="btn btn-success">ADD ITEM</button></td>');
                    $("#data").append('</tbody></table>');

               }
          });
     }
     getData();

});

$(document).on("click", "#btn_insert", function() {
     //validate id
     id = $('#id_insert').text();
     id = parseInt(id);
     if (isNaN(id) === true) {
          alert("ID phai la so nguyen");
          return false;
     }

     //validate name
     name = $('#name_insert').text();
     if ( name.length < 5 || name.length > 40) {
          alert("Do dai chuoi chi tu 5 den 40 ki tu") ;
          return false;
     }

     //validate year
     year = $('#year_insert').text();
     year =  parseInt(year); 
     if (isNaN(year) == true || year < 1990 || year > 2015) {
          alert("Gia tri nam trong khoang 1990 - 2015");
          return false;
     }
     action = "insert";
     $.ajax({
          url:"http://localhost/cau2/api/test_api.php",
          method:"POST",
          data:{
               id: id,
               name: name,
               year: year,
               action: action
          },
          success:function(data){
               console.log(data);
               if(data == ''){
                    alert("Nhap lai ID") ? "" : location.reload();
               } else{
                    location.reload();
               }
          }
     });
});

function update_data(id, text, column_name) {  
     var action = "update";
     $.ajax({
          url:"http://localhost/cau2/api/test_api.php",
          method:"POST",  
          data:{
               id:id, 
               text:text, 
               column_name:column_name,
               action: action
          },  
          dataType:"text",
          success:function(data){
               data = JSON.parse(data);
               $('#msg').html("<div class='alert alert-success'>"+data["msg"]+"</div>");
          }
    });  
}

$(document).on("blur", ".name-result", function() {
     var id = $(this).data("name");
     var name = $(this).text();
     if (name =='' || name.length < 5 || name.length > 40) {
        alert(" Please enter name must be lenght 5 to 40 characters") ? "" : location.reload();
    } else{
        update_data(id, name, "name");  
    };
});

$(document).on("blur", ".year-result", function() {
     var id = $(this).data("year");
     var year = $(this).text();
     var year =  parseInt(year);
     if (isNaN(year) == true || year =='' || year < 1990 || year > 2015) {
          alert(" Please enter year must be from 1990 to 2015 ") ? "" : location.reload();
     } else{
          update_data(id,year, "year");  
     };
});

$(document).on("click", ".btn_delete", function(){
     var action = "delete";
     var id=$(this).data("id");  
     if(confirm("Ban chac chan xoa chu ??")) {
          $.ajax({  
               url:"http://localhost/cau2/api/test_api.php",  
               method:"POST",  
               data:{
                    id:id,
                    action:action
               },  
               dataType:"text",  
               success:function(data){
                    data = JSON.parse(data);
                    alert(data["msg"]) ? "" : location.reload();  
               }  
          });
     }
})

</script>