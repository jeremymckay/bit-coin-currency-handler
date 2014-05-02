<html>
<head>
    <title>Bitcoin Currency Converter</title>
</head>
<body>
<?php
// Make sure the user submitted all of the data required
if ( isset( $_POST['amount'] ) && is_numeric( $_POST['amount'] ) && isset( $_POST['currency'] ) ) {
    // Use curl to perform the currency conversion
    // using Blockchain.info's currency conversion API
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, "https://blockchain.info/tobtc?currency=" . $_POST['currency'] . "&value=" . $_POST['amount'] );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $conversion = curl_exec( $ch );
    // Use curl to get current prices and 15 minute averages for all currencies
    // from Blockchain.info's exchange rates API
    curl_setopt( $ch, CURLOPT_URL, "https://blockchain.info/ticker" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $prices = json_decode( curl_exec( $ch ), true ); curl_close( $ch ); ?>
    <h1>Conversion Results</h1> <p><?php echo $_POST['amount']; ?>
    <?php echo $_POST['currency']; ?> is <?php echo $conversion; ?> BTC.</p>
    <h2>Historical Prices</h2> <p><strong>Last price:</strong>
    <?php echo $prices[$_POST['currency']]['last']; ?>
    <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
    <p><strong>Buy price:</strong> <?php echo $prices[$_POST['currency']]['buy']; ?>
        <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
        <p><strong>Sell price:</strong> <?php echo $prices[$_POST['currency']]['sell']; ?>
            <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
            <p><strong>15 minute average price:</strong>
    <?php echo $prices[$_POST['currency']]['15m']; ?>
    <?php echo $prices[$_POST['currency']]['symbol']; ?></p>
    <?php } else { ?>
    <p>Please fill out the form completely. <a href="index.php">Go back.</a></p>
    <?php } ?>
</body>
</html>

<!-- Read more: http://blog.programmableweb.com/2014/05/01/how-to-build-a-bitcoin-currency-converter-using-the-blockchain-info-apis/#ixzz30Yel08FZ
Follow us: @ProgrammableWeb on Twitter | ProgrammableWeb on Facebook -->
