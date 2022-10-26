
      <footer class="footer py-4">
       
       </footer>
     </div>
   </main>
   
   <!--   Core JS Files   -->
   <script src="../../assets/js/core/popper.min.js"></script>
   <script src="../../assets/js/core/bootstrap.min.js"></script>
   <script src="../../assets/js/jquery-3.3.1.min.js"></script>
   <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
   <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
   <script src="../../assets/js/plugins/chartjs.min.js"></script>
   
   <script>
     $(document).ready(function(){

      $(".add-to-cart-btn").click(function() {

        var input_id = $(this).attr('id');
       
        $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'addtocart': true, 'input_id': input_id }
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                  // alert("Item added to your cart");
                  var confirmation = "<p class='text-sm' > Added to Cart</p>";

                  $("#" + input_id).before(confirmation);
                  $("#" + input_id).hide();
                  

                } else{
                  alert("Some error occured");
                  
                    
                }
            });

                      
        });
        

        $(".product-footer div span.increase").click(function(){
          
          let count = $(this).prev().text();
          let maximum = $(this).attr('data-max');
          let cart = $(this).attr('data-id');
          ++count;
          count = count > maximum ? maximum : count;
          $(this).prev().text(count);

         

          $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'updatecart': true, 'id': cart, 'quantity': count }
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                  let subtotal = count * data.price;
                  $('#subtotal-' + cart).text('Total ' + subtotal.toFixed(2) +' /=');
                  

                } else{
                  alert("Some error occured");
                  
                    
                }
            });
          
          
        });

        $(".product-footer div span.decrease").click(function(){
          let count = $(this).next().text();
          let cart = $(this).attr('data-id');
          --count;
          count = count < 1 ? 1 : count;
          $(this).next().text(count);

          $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'updatecart': true, 'id': cart, 'quantity': count }
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                 
                  let subtotal = count * data.price;
                  $('#subtotal-' + cart).text('Total ' + subtotal.toFixed(2) +' /=');
                  
                  

                } else{
                  alert("Some error occured");
                  
                    
                }
            });

          
        });

        $(".product-footer .remove-cart").click(function(){
          let cart = $(this).attr('data-id');
          
          $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'removecart': true, 'id': cart }
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                  $('#cart-' + cart).hide();
                  // alert("Item removed from your cart");
                  

                } else{
                  alert("Some error occured");
                  
                    
                }
            });
          
        });

        $(".checkoff-btn").click(function(){
          
          $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'checkoff': true }
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                  window.location.reload(true);  

                } else{
                  alert(data.message);
                  
                    
                }
            });
        });

        $(".cancel-order").click(function(){
          let order_id = $(this).attr('id');

          $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'cancelorder': true , 'order_id':order_id}
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                  window.location.reload(true);  

                } else{
                  alert(data.message);
                  
                    
                }
            });

        });

        

        $(".cancel-input-order").click(function(){
          let id = $(this).attr('id');
          let input_id = $(this).attr('data-input-id');

          $.ajax({
            method: "POST",
            url: "ajaxcart.php",
            data: { 'cancelinputorder': true , 'id':id , 'input_id':input_id}
            })
            .done(function( response ) {
                var data = JSON.parse(response);

                if(data.success == true){ 
                  // window.location.reload(true);  

                } else{
                  alert(data.message);
                  
                    
                }
            });

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
 
 
     var ctx2 = document.getElementById("chart-line").getContext("2d");
 
     new Chart(ctx2, {
       type: "line",
       data: {
         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
         datasets: [{
           label: "Mobile apps",
           tension: 0,
           borderWidth: 0,
           pointRadius: 5,
           pointBackgroundColor: "rgba(255, 255, 255, .8)",
           pointBorderColor: "transparent",
           borderColor: "rgba(255, 255, 255, .8)",
           borderColor: "rgba(255, 255, 255, .8)",
           borderWidth: 4,
           backgroundColor: "transparent",
           fill: true,
           data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
           maxBarThickness: 6
 
         }],
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
           x: {
             grid: {
               drawBorder: false,
               display: false,
               drawOnChartArea: false,
               drawTicks: false,
               borderDash: [5, 5]
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
 
     var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");
 
     new Chart(ctx3, {
       type: "line",
       data: {
         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
         datasets: [{
           label: "Mobile apps",
           tension: 0,
           borderWidth: 0,
           pointRadius: 5,
           pointBackgroundColor: "rgba(255, 255, 255, .8)",
           pointBorderColor: "transparent",
           borderColor: "rgba(255, 255, 255, .8)",
           borderWidth: 4,
           backgroundColor: "transparent",
           fill: true,
           data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
           maxBarThickness: 6
 
         }],
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
               display: true,
               padding: 10,
               color: '#f8f9fa',
               font: {
                 size: 14,
                 weight: 300,
                 family: "Roboto",
                 style: 'normal',
                 lineHeight: 2
               },
             }
           },
           x: {
             grid: {
               drawBorder: false,
               display: false,
               drawOnChartArea: false,
               drawTicks: false,
               borderDash: [5, 5]
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
 </body>
 
 </html>