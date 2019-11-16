<?php namespace {
    use Model\CardDealerShoe;
    use Model\Dealer;
    use Model\Player;
    use Model\Strategy\MartingaleMixedStrategy;
    use Model\Strategy\MartingaleStrategy;
    use Model\Strategy\ReverseMartingaleStrategy;

    ?><html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <ol>
<?php
    set_time_limit(0);

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

    $startingCash   = 5000;
    $dailyEarnGoal  = 100;
    $maxGamesPerDay = 1000;
    $strategy       = new MartingaleStrategy(10, 500, 4500, $startingCash + $dailyEarnGoal);

    $finalBalance = 0;

    for( $day=0; $day < 30; $day++ ) {
        $shoe       = new CardDealerShoe(8);
        $dealer     = new Dealer($shoe);
        $player     = new Player($strategy, "Player 1", $startingCash, false);
        $dealer->addPlayer( $player );

        for( $i=0; $i < $maxGamesPerDay; $i++ ) {
            $continue = $dealer->runHand();
            if( !$continue ) {
                break;
            }
            if( $maxGamesPerDay == $i+1 ) {
                echo("<li><span class='label label-default'>Done for the Day</span> his maximum # of hands played.</li>");
            }
        }
        $todaysBalance = $player->MoneyLeft - $startingCash;
        $finalBalance  += $todaysBalance;
        echo("\r\n<li>Today's win/loss: <span class='label label-".($todaysBalance > 0 ? "success" : "danger")."'>{$todaysBalance}</span> <span class='label label-default'>{$finalBalance}</span></li>");
    }
    echo("\r\n<li>Final Money Earned: {$finalBalance}</li>");
?>
    </ol>
</body>
</html>
<?php } // close namespace ?>