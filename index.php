<?php
/*
   This is the example block explorer of RPC Ace. If you intend to use just
   the RPCAce class itself to fetch and process the array or JSON output on
   your own, you should remove this entire PHP section.
*/

require('rpcace.php');
$query = substr( @$_SERVER['QUERY_STRING'], 0, 64 );

if( strlen($query) == 64 )
    $ace = RPCAce::get_block( $query );
else
{
    $query = ( $query === false || !is_numeric($query) ) ? null : abs( (int)$query );
    $ace = RPCAce::get_blocklist( $query, BLOCKS_PER_LIST );
    $query = $query === null ? @$ace['num_blocks'] : $query;
}

if( isset($ace['err']) || RETURN_JSON === true )
    die( 'RPC Ace error: ' . (RETURN_JSON ? $ace : $ace['err']) );

echo <<<END
<!DOCTYPE html>
<!--
    (Simple Crown PHP explorer)

    (c) 2019 Defunctec

    https://github.com/defunctec/Simple-Crown-Block-explorer-PHP
-->
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="robots" content="index,nofollow,nocache" />
<meta name="author" content="Robin Leffmann (djinn at stolendata dot net)" />

END;

if( empty($query) || ctype_digit($query) )
    echo '<meta http-equiv="refresh" content="' . REFRESH_TIME . '; url=' . basename( __FILE__ ) . "\" />\n";
echo '<title>' . COIN_NAME . ' block explorer &middot; RPC Ace v' . ACE_VERSION . "</title>\n";

echo <<<END
<link href="https://fonts.googleapis.com/css?family=Varela" rel="stylesheet" type="text/css">
<style type="text/css">
html { height: 100%;
       background: linear-gradient( to bottom, #80a4b4, #13437a );
       background-attachment: fixed;
       color: #f6f6f6;
       font-family: Varela, sans-serif;
       font-size: 17px;
       white-space: pre; }
a { color: #f6f6f6; }
div.mid { width: 900px;
          margin: 2% auto; }
td { width: 16%; }
td.urgh { width: 100%; }
td.key { text-align: right; }
td.value { padding-left: 16px; width: 100%; }
tr.illu:hover { background-color: #303030; }
</style>
</head>
<body>
<div class="mid">
END;

// header
echo '<table><tr><td class="urgh"><b><a href="' . COIN_HOME . '" target="_blank">' . COIN_NAME . '</a></b> block explorer</td><td>Blocks:</td><td><a href="?' . $ace['num_blocks'] . '">' . $ace['num_blocks'] . '</a>';
$diffNom = 'Difficulty';
$diff = sprintf( '%.3f', $ace['current_difficulty_pow'] );
if( COIN_POS )
{
    $diffNom .= ' &middot; PoS';
    $diff .= ' &middot;' . sprintf( '%.1f', $ace['current_difficulty_pos'] );
}
echo "<tr><td></td><td>$diffNom:</td><td>$diff</td></tr>";
echo '<tr><td>Powered by <a href="https://github.com/stolendata/rpc-ace/" target="_blank">RPC Ace</a> v' . ACE_VERSION . ' (RPC AnyCoin Explorer)</td><td>Network hashrate: </td><td>' . $ace['hashrate_mhps'] . ' MH/s</td></tr><tr><td> </td><td></td><td></td></tr></table>';

// list of blocks
if( isset($ace['blocks']) )
{
    echo "<table><tr><td><b>Block</b></td><td><b>Hash</b></td><td><b>$diffNom</b></td><td><b>Time (UTC)</b></td><td><b>Tx# &middot; Value out</b></td></tr><tr><td colspan=\"5\"></td></tr>";
    foreach( $ace['blocks'] as $block )
        echo "<tr class=\"illu\"><td>{$block['height']}</td><td><a href=\"?{$block['hash']}\">" . substr( $block['hash'], 0, 16 ) . '&hellip;</a></td><td>' . sprintf( '%.2f', $block['difficulty'] ) . "</td><td>{$block['date']}</td><td>{$block['tx_count']} &middot; " . sprintf( '%.2f', $block['total_out'] ) . '</td></tr>';

    $newer = $query < $ace['num_blocks'] ? '<a href="?' . ( $ace['num_blocks'] - $query >= BLOCKS_PER_LIST ? $query + BLOCKS_PER_LIST : $ace['num_blocks'] ) . '">&lt; Newer</a>' : '&lt; Newer';
    $older = $query - count( $ace['blocks'] ) >= 0 ? '<a href="?' . ( $query - BLOCKS_PER_LIST ) . '">Older &gt;</a>' : 'Older &gt;';

    echo "<tr><td colspan=\"5\" class=\"urgh\"> </td></tr><tr><td colspan=\"5\">$newer          $older</td></tr></table>";
}
// block details
elseif( isset($ace['transactions']) )
{
    echo '<table>';
    foreach( $ace['fields'] as $field => $val )
        if( $field == 'previousblockhash' || $field == 'nextblockhash' )
            echo "<tr><td class=\"key\">$field</td><td class=\"value\"><a href=\"?$val\">$val</a></td></tr>";
        else
            echo "<tr><td class=\"key\">$field</td><td class=\"value\">$val</td></tr>";

    foreach( $ace['transactions'] as $tx )
    {
        echo "<tr><td class=\"key\">tx</td><td class=\"value\">{$tx['id']}</td></tr>";
        foreach( $tx['outputs'] as $output )
            echo '<tr><td></td><td class="value">     ' . $output['value'] . ( isset( $tx['coinbase'] ) ? '*' : '' ) . " -&gt; {$output['address']}</td></tr>";
    }

    echo'</table>';
}

echo '</div></body></html>'
?>