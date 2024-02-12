<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="./public/js/hideShow.js"></script>
<script src="./public/js/oldHideShow.js"></script>
<script src="./public/js/autoCloseAlert.js"></script>
<!-- Chatgpt ile anlık olarak saat ve gün bilgisi gösterimi -->
<script>
        function updateClock() {
            var now = new Date();

            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            var day = now.getDate();
            var month = now.getMonth() + 1; // JavaScript'te aylar 0-11 arasında indekslenir, bu yüzden +1 ekliyoruz.
            var year = now.getFullYear();

            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            month = month < 10 ? '0' + month : month;
            day = day < 10 ? '0' + day : day;

            var timeString = hours + ':' + minutes + ':' + seconds;
            var dateString = day + '/' + month + '/' + year;

            var fullDateTimeString = "Date And Time: "+dateString +" "+ timeString;

            // Zaman ve tarih bilgisini HTML içindeki h1 etiketinin zaman özelliğine ata
            document.getElementById('clock').innerText = fullDateTimeString;

            setTimeout(updateClock, 1000); // Her saniye güncelle
        }

        window.onload = function () {
            updateClock();
        };
    </script>
        <!--      Datatables için gerekli cdnler-->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script
<script>
  //! Datatablestaki export butonlarının düzenlenmesi
$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        dom: 'lBfrtip',
        buttons: {
        buttons: [
          { extend: 'pageLength', className: 'btn-primary'},
            { extend: 'copy', className: 'btn btn-dark'},
            { extend: 'excel', className: 'btn btn-success'},
            { extend: 'csv', className: 'btn btn-danger' },
            { extend: 'pdf', className: 'btn btn-warning' },
            { extend: 'print', className: 'btn btn-secondary' },
            { extend: 'colvis', className: 'btn btn-info' }
        ]
      }
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
/* buttons: [ 'copy', 'excel','csv', 'pdf', 'colvis' ] */
/* pagingType: 'full_numbers', */
/* language: {
        info: 'Showing page _PAGE_ of _PAGES_',
        infoEmpty: 'No records available',
        infoFiltered: '(filtered from _MAX_ total records)',
        lengthMenu: 'Display _MENU_ records per page',
        zeroRecords: 'Nothing found - sorry'
    } */
</script>
  </body>
</html>
