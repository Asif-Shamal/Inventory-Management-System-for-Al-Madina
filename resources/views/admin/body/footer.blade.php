<footer class="footer">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
        
            <!-- Display Date -->
            <div>{{ \Carbon\Carbon::now()->toDateString() }}</div>
        
            <!-- Display Time -->
            <div id="time">{{ \Carbon\Carbon::now()->format('H:i:s') }}</div>
        </div>
    </div>
</footer>




<!-- footer clock -->
<script>
    function updateTime() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
        const timeString = now.toLocaleTimeString('en-US', options);
        document.getElementById("time").innerText = timeString;
    }

    setInterval(updateTime, 1000);

    window.onload = updateTime;
</script>
