Simple Crown PHP explorer
==============================

Forked from ([RPCACE](https://github.com/stolendata/rpc-ace))

Setting up PHP block explorer
------------------

1. Download the latest Crown client https://github.com/Crowndev/crown-core/releases
2. You must set `txindex=1` in the crown.conf file before downloading a brand new chain.
3. You need ([EasyCrown](https://github.com/defunctec/EasyCrown-PHP)) to use Simple Crown PHP explorer.
4. Place `rpcace.php` and `easycrown.php` together in your web directory.
5. Edit `rpcace.php` to connect to your local Crown client.

    RPC_HOST = 'localhost'              // Host/IP for the daemon
    RPC_PORT = 9341                     // RPC port for the daemon
    RPC_USER = 'username'               // 'rpcuser' from the coin's .conf
    RPC_PASS = 'password'               // 'rpcpassword' from the coin's .conf

    COIN_NAME = 'Crown'                 // Coin name/title
    COIN_POS = true                     // Set to true for proof-of-stake coins

    RETURN_JSON = false                 // Set to true to return JSON instead of PHP arrays
    DATE_FORMAT = 'Y-M-d H:i:s'         // Date format for blocklist
    BLOCKS_PER_LIST = 12                // Number of blocks to collect for the blocklist

    DB_FILE = '/var/www/databases/crown.db';     // Set to false to disable database storage

    // for the example explorer
    COIN_HOME = 'https://crown.tech'    // Coin website
    REFRESH_TIME = 120                  // Seconds between automatic HTML page refresh


6. For databaste storage we use "/var/www/databases/crown.db", you may need to make the folder read/writeable (Permissions).

Extras
------

`tally.php` generates a "richlist". Usage: configure user/pass/host/port in the beginning of the file, and then run from command line: `php tally.php <output>`. Accurate results require the block chain being built with full transaction indexing. Avoid storing `tally.php` in your web directory where users may run it remotely, as it can be very time- and CPU-consuming when parsing long block chains.

When finished parsing blocks, `tally.php` will output its progress to a file named `RPCUSER-RPCPORT-tally.dat` which will be used to resume operations next time `tally.php` runs in order to avoid having to start over from block 1 when updating a list. Aborting the script while running by pressing `CTRL+C` will also save the progress file for later use.


Donations
---------

CRW: CRWJPWadh8aM4Tps8mJALLP3HhSfvE6s4DBm
BTC: 15a3VPqWhFfuSZZgBubKzKqeqaRFJGwEEm
