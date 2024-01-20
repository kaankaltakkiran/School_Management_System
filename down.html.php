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
  </body>
</html>
