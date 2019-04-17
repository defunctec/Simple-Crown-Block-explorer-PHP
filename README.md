Simple Crown PHP explorer
==============================

Forked from ([RPCACE](https://github.com/stolendata/rpc-ace))

Uses ([EasyCrown](https://github.com/defunctec/EasyCrown-PHP))

Setting up PHP block explorer
------------------

1. Download the latest Crown client https://github.com/Crowndev/crown-core/releases
2. You must set `txindex=1` in the crown.conf file before downloading a brand new chain.
4. Make sure `rpcace.php`, `easycrown.php` and `index.php` are together in your web directory.
5. Edit `rpcace.php` to connect to your local Crown client.
6. For databaste storage we use "/var/www/databases/crown.db", you may need to make the folder read/writeable (Permissions).
7. Use "http://YOURWEBSERVERIP/index.php" to connect to the explorer

Extras
------
UNDER CONSTRUCTION 

`tally.php` generates a "richlist". Usage: configure user/pass/host/port in the beginning of the file, and then run from command line: `php tally.php <output>`. Accurate results require the block chain being built with full transaction indexing. Avoid storing `tally.php` in your web directory where users may run it remotely, as it can be very time- and CPU-consuming when parsing long block chains.

When finished parsing blocks, `tally.php` will output its progress to a file named `RPCUSER-RPCPORT-tally.dat` which will be used to resume operations next time `tally.php` runs in order to avoid having to start over from block 1 when updating a list. Aborting the script while running by pressing `CTRL+C` will also save the progress file for later use.


Donations
---------

CRW: CRWJPWadh8aM4Tps8mJALLP3HhSfvE6s4DBm
BTC: 15a3VPqWhFfuSZZgBubKzKqeqaRFJGwEEm
