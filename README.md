Simple Crown PHP explorer
==============================

Forked from ([RPCACE](https://github.com/stolendata/rpc-ace))

Uses ([EasyCrown](https://github.com/defunctec/EasyCrown-PHP))

Setting up PHP block explorer
------------------

### Download the latest Crown client

Download the Crown client

	$ wget "https://github.com/Crowndev/crown-core/releases/download/v0.13.2.0/Crown-0.13.2.0-Linux64.zip" -O $dir/crown.zip

Install

	$ apt install unzip -y
	$ unzip -d $dir/crown $dir/crown.zip
	$ cp -f $dir/crown/*/bin/* /usr/local/bin/
	$ cp -f $dir/crown/*/lib/* /usr/local/lib/
	$ rm -rf $dir
	$ crownd

Edit the crown.conf file

    daemon=1
    server=1
    disablewallet=0
    rpcuser=YOURCROWNRPCUSER
    rpcpassword=YOURCROWNRPCPASS
    txindex=1
    rpcallowip=YOURPCIPADDRESS
    maxconnections=12

Download bootstrap (Optional)

	$ wget "https://nextcloud.crown.tech/nextcloud/s/RiyWmDLckmcXS6n/download" -O chain.7z
	$ unzip chain.7z
	$ mv bootstrap.dat /root/.crown

Start the wallet

	$ crownd

### Install required packages
	
	Install LAMP ([Guide](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04))

	Without this the explorer will throw a PDO error
	$ sudo apt install php7.0-sqlite3

### Clone or download ([Crown php Explorer](https://github.com/defunctec/Simple-Crown-Block-explorer-PHP))
	
	Add files to /var/www/html
	Make sure `rpcace.php`, `easycrown.php` and `index.php` are together in your web directory.

### Edit the wallet RPC details to connect to your local Crown client.

	$ nano /var/www/html/rpcace.php

Example

	const RPC_HOST = 'localhost';
	const RPC_PORT = 9341;
	const RPC_USER = 'RPCusername';
	const RPC_PASS = 'RPCpassword';

### For databaste storage we use "/var/www/databases/crown.db", you may need to make the folder read/writeable (Permissions).

Make a folder for the database
	
	$ mkdir /var/www/databases

### Test the explorer

	Use "http://YOURWEBSERVERIP/index.php" to connect to the explorer

Extras
------
UNDER CONSTRUCTION 

`tally.php` generates a "richlist". Usage: configure user/pass/host/port in the beginning of the file, and then run from command line: `php tally.php <output>`. Accurate results require the block chain being built with full transaction indexing. Avoid storing `tally.php` in your web directory where users may run it remotely, as it can be very time- and CPU-consuming when parsing long block chains.

When finished parsing blocks, `tally.php` will output its progress to a file named `RPCUSER-RPCPORT-tally.dat` which will be used to resume operations next time `tally.php` runs in order to avoid having to start over from block 1 when updating a list. Aborting the script while running by pressing `CTRL+C` will also save the progress file for later use.


Donations
---------

CRW: CRWJPWadh8aM4Tps8mJALLP3HhSfvE6s4DBm
BTC: 15a3VPqWhFfuSZZgBubKzKqeqaRFJGwEEm
