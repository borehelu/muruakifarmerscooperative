
      <footer class="footer py-4">
       
       </footer>
     </div>
   </main>
   
   <!--   Core JS Files   -->
      
   <!-- <script src="../../assets/js/jquery-3.3.1.min.js"></script> -->
   <script src="../../assets/js/bootstrap.min.js"></script>
   <script src="../../assets/js/core/popper.min.js"></script>
   <script src="../../assets/js/core/bootstrap.min.js"></script>
   <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
   <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
   <script src="../../assets/js/plugins/chartjs.min.js"></script>

   <script>
     $(document).ready(function(){


       // validate email

       $("#email").change(function () {
            var email =$(this).val();

           
              $.ajax({
              method: "POST",
              url: "ajaxvalidateusers.php",
              data: { 'email': email  }
              })
              .done(function( response ) {
                  var data = JSON.parse(response);

                  if(data.exists == true){ 
                     $(".error-msg-email").css("display","block");
                     $("#add-user").prop("disabled",true);

                  } else{
                    $(".error-msg-email").css("display","none");
                     $("#add-user").prop("disabled",false);
                   
                      
                  }
              });

            
            
        });


        // validate phone

        $("#phone").change(function () {

          var phone=$(this).val();

                        
              $.ajax({
              method: "POST",
              url: "ajaxvalidateusers.php",
              data: { 'phone': phone }
              })
              .done(function( response ) {
                  var data = JSON.parse(response);

                  if(data.exists == true){ 
                    $(".error-msg-phone").css("display","block");
                    $("#add-user").prop("disabled",true);

                  } else{
                    $(".error-msg-phone").css("display","none");
                    $("#add-user").prop("disabled",false);
                  
                      
                  }
              });


            
        });

        $("#generate-report-orders").click(function(){
          let order_date = $("#order-date").val();
          window.open("../reports/adminorders.php?order-date=" + order_date);
          $("#generateOrdersReport").modal("hide");

        });

     });
   </script>
   <script>
     var ctx = document.getElementById("chart-bars").getContext("2d");
 
     new Chart(ctx, {
       type: "bar",
       data: {
         labels: ["M", "T", "W", "T", "F", "S", "S"],
         datasets: [{
           label: "Sales",
           tension: 0.4,
           borderWidth: 0,
           borderRadius: 4,
           borderSkipped: false,
           backgroundColor: "rgba(255, 255, 255, .8)",
           data: [50, 20, 10, 22, 50, 10, 40],
           maxBarThickness: 6
         }, ],
       },
       options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
           legend: {
             display: false,
           }
         },
         interaction: {
           intersect: false,
           mode: 'index',
         },
         scales: {
           y: {
             grid: {
               drawBorder: false,
               display: true,
               drawOnChartArea: true,
               drawTicks: false,
               borderDash: [5, 5],
               color: 'rgba(255, 255, 255, .2)'
             },
             ticks: {
               suggestedMin: 0,
               suggestedMax: 500,
               beginAtZero: true,
               padding: 10,
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
               color: "#fff"
             },
           },
           x: {
             grid: {
               drawBorder: false,
               display: true,
               drawOnChartArea: true,
               drawTicks: false,
               borderDash: [5, 5],
               color: 'rgba(255, 255, 255, .2)'
             },
             ticks: {
               display: true,
               color: '#f8f9fa',
               padding: 10,
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
             }
           },
         },
       },
     });
 
 
     var ctx2 = document.getElementById("chart-bars-deliveries").getContext("2d");
 
     new Chart(ctx2, {
       type: "bar",
       data: {
         labels: ["M", "T", "W", "T", "F", "S", "S"],
         datasets: [{
           label: "Sales",
           tension: 0.4,
           borderWidth: 0,
           borderRadius: 4,
           borderSkipped: false,
           backgroundColor: "rgba(255, 255, 255, .8)",
           data: [50, 20, 10, 22, 50, 10, 40],
           maxBarThickness: 6
         }, ],
       },
       options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
           legend: {
             display: false,
           }
         },
         interaction: {
           intersect: false,
           mode: 'index',
         },
         scales: {
           y: {
             grid: {
               drawBorder: false,
               display: true,
               drawOnChartArea: true,
               drawTicks: false,
               borderDash: [5, 5],
               color: 'rgba(255, 255, 255, .2)'
             },
             ticks: {
               suggestedMin: 0,
               suggestedMax: 500,
               beginAtZero: true,
               padding: 10,
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
               color: "#fff"
             },
           },
           x: {
             grid: {
               drawBorder: false,
               display: true,
               drawOnChartArea: true,
               drawTicks: false,
               borderDash: [5, 5],
               color: 'rgba(255, 255, 255, .2)'
             },
             ticks: {
               display: true,
               color: '#f8f9fa',
               padding: 10,
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
             }
           },
         },
       },
     });
 
 
     var ctx3 = document.getElementById("chart-bars-inputs").getContext("2d");
 
     new Chart(ctx3, {
       type: "bar",
       data: {
         labels: ["M", "T", "W", "T", "F", "S", "S"],
         datasets: [{
           label: "Sales",
           tension: 0.4,
           borderWidth: 0,
           borderRadius: 4,
           borderSkipped: false,
           backgroundColor: "rgba(255, 255, 255, .8)",
           data: [50, 20, 10, 22, 50, 10, 40],
           maxBarThickness: 6
         }, ],
       },
       options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
           legend: {
             display: false,
           }
         },
         interaction: {
           intersect: false,
           mode: 'index',
         },
         scales: {
           y: {
             grid: {
               drawBorder: false,
               display: true,
               drawOnChartArea: true,
               drawTicks: false,
               borderDash: [5, 5],
               color: 'rgba(255, 255, 255, .2)'
             },
             ticks: {
               suggestedMin: 0,
               suggestedMax: 500,
               beginAtZero: true,
               padding: 10,
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
               color: "#fff"
             },
           },
           x: {
             grid: {
               drawBorder: false,
               display: true,
               drawOnChartArea: true,
               drawTicks: false,
               borderDash: [5, 5],
               color: 'rgba(255, 255, 255, .2)'
             },
             ticks: {
               display: true,
               color: '#f8f9fa',
               padding: 10,
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
             }
           },
         },
       },
     });
   </script>
   <script>
     var win = navigator.platform.indexOf('Win') > -1;
     if (win && document.querySelector('#sidenav-scrollbar')) {
       var options = {
         damping: '0.5'
       }
       Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
     }
   </script>
   <!-- Github buttons -->
   <script async defer src="https://buttons.github.io/buttons.js"></script>
   <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
   <script src="../../assets/js/material-dashboard.min.js?v=3.0.0"></script>
   <script src='http://localhost/menora/assets/js/menora.js' id='widget-script' data-apikey='XRdBAVB2AXdzOL6MMlN0UbPf8xhkD0wJ'></script>
 </body>
 
 </html>