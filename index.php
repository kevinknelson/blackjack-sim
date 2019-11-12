<?php namespace {
    use Model\CardDealerShoe;
    use Model\Dealer;
    use Model\Player;
    use Model\Strategy\MartingaleStrategy;

?><html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php


    spl_autoload_register( function( $className ) {
        if( strpos($className,"\\")!==false ) {
            $path           = str_replace("\\",'/',$className);
            $mainPath       = __DIR__."/{$path}.php";
            if( is_file($mainPath) ) {
                require_once($mainPath);
                return true;
            }
        }
        return false;
    });


    $strategy   = new MartingaleStrategy(1,16);
    $shoe       = new CardDealerShoe(8);
    $dealer     = new Dealer($shoe);
    $player     = new Player($strategy, "Player 1", 512);
    $dealer->addPlayer( $player );

    for( $i=0; $i < 60; $i++ ) {
        $dealer->runHand();
    }
?>
</body>
</html>
<?php } // close namespace ?>