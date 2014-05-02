<html>
<head>
    <title>Bitcoin Currency Converter</title>
<script type="text/javascript" src="//www.google.com/jsapi">
</script>
<script type="text/javascript">
google.load('visualization', '1', {packages: ['corechart']}); </script>
</head>
<body> <?php
// Make sure the user submitted all of the data required
if ( isset( $_POST['amount'] ) && is_numeric( $_POST['amount'] ) && isset( $_POST['currency'] ) ) {
    // Use curl to perform the currency conversion using Blockchain.info's currency conversion API
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, "https://blockchain.info/tobtc?currency="
        . $_POST['currency'] . "&value=" . $_POST['amount'] );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $conversion = curl_exec( $ch );
    // Use curl to get current prices and 15 minute averages for
    //all currencies from Blockchain.info's exchange rates API
    curl_setopt( $ch, CURLOPT_URL, "https://blockchain.info/ticker" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $prices = json_decode( curl_exec( $ch ), true );
    curl_close( $ch ); ?>
    <h1>Conversion Results</h1>
    <p><?php echo $_POST['amount']; ?>
        <?php echo $_POST['currency']; ?> is <?php echo $conversion; ?> BTC.</p>
    <h2>Historical Prices</h2>
    <p><strong>Last price:</strong>
        <?php echo $prices[$_POST['currency']]['last']; ?>
        <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
        <p><strong>Buy price:</strong>
            <?php echo $prices[$_POST['currency']]['buy']; ?>
            <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
            <p><strong>Sell price:</strong>
                <?php echo $prices[$_POST['currency']]['sell']; ?>
                <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
                <p><strong>15 minute average price:</strong>
                    <?php echo $prices[$_POST['currency']]['15m']; ?>
                    <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
<?php
    // Display the pricing chart if we're doing a US Dollar conversion
    if ( $_POST['currency'] == "USD" ) {
        // Use curl to get pricing chart data for the past 60 days
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, "https://blockchain.info/charts/market-price?showDataPoints=true&timespan=60days&show_header=true&daysAverageString=7&scale=0&format=json" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $chartdata = json_decode( curl_exec( $ch ), true ); ?>
    <div id="chart" style="width: 1000px; height: 500px;"></div>
    <script type="text/javascript"> function drawChart() {
        var data = google.visualization.arrayToDataTable([ ['Day', 'Price'],
        <?php
        // Loop through the x-y coordinates Blockchain.info's API provides
        //and add them to a JavaScript array
        foreach ( $chartdata["values"] as $xy ) {
            echo "['" . date( "Y/m/d", $xy["x"] ) . "'," . $xy["y"] . "],"; } ?> ]);
            new google.visualization.LineChart(
                document.getElementById("chart")).draw(data, {
                    curveType: "function", width: 1000, height: 500, vAxis: {maxValue: 800}} );
                     } drawChart();
                      </script>
                      <?php } ?>
                      <?php } else { ?>
                      <p>Please fill out the form completely.
                        <a href="index.php">Go back.</a></p> <?php } ?>
</body>
</html>

<!-- Read more: http://blog.programmableweb.com/2014/05/01/how-to-build-a-bitcoin-currency-converter-using-the-blockchain-info-apis/#ixzz30Yel08FZ
Follow us: @ProgrammableWeb on Twitter | ProgrammableWeb on Facebook -->
