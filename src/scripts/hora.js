
    function updateClock() {
        var now = new Date();
        var day = now.getDate();
        var month = now.getMonth() + 1;
        var year = now.getFullYear();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var dateString = (day < 10 ? '0' : '') + day + '/' + 
                         (month < 10 ? '0' : '') + month + '/' + 
                         year;
        var timeString = (hours < 10 ? '0' : '') + hours + ':' + 
                         (minutes < 10 ? '0' : '') + minutes + ':' + 
                         (seconds < 10 ? '0' : '') + seconds;
        document.getElementById('date').value = dateString + ' ' + timeString;
    }

    setInterval(updateClock, 1000);
    updateClock(); // Initial call to set the clock immediately