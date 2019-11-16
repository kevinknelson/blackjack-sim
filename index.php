<?php namespace {
    use Model\CardDealerShoe;
    use Model\Dealer;
    use Model\HitStrategy\DefaultCardCountingStrategy;
    use Model\HitStrategy\DefaultHitStrategy;
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

    $startingCash   = 25000;
    $minimumBet     = 5;
    $maximumBet     = 500;
    $dailyEarnGoal  = 10;
    $dailyMaxLoss   = 500;
    $maxGamesPerDay = 1000;
    $betStrategy    = new ReverseMartingaleStrategy($minimumBet, $maximumBet, $startingCash - $dailyMaxLoss, $startingCash + $dailyEarnGoal);
    $hitStrategy    = new DefaultCardCountingStrategy();

    $finalBalance = 0;

    for( $day=0; $day < 365; $day++ ) { // play for a year and see what happens
        $shoe       = new CardDealerShoe(8);
        $dealer     = new Dealer($shoe);
        $player     = new Player($betStrategy, $hitStrategy, "Player 1", $startingCash, false);
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