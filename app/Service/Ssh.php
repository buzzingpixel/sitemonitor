<?php

namespace App\Service;

use App\User;
use App\Server;
use phpseclib\Net\SSH2;
use phpseclib\Crypt\RSA;
use App\DataModel\ServerAuthorizedKey;
use BuzzingPixel\DataModel\ModelCollection;

/**
 * Class Ssh
 */
class Ssh
{
    /** @var User $user */
    private $user;

    /**
     * Constructor
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get SSH Connection
     * @param Server $server
     * @return SSH2|string
     */
    public function getConnection(Server $server)
    {
        // Check for user's SSH key specific to this server
        $sshKey = $this->user->sshServerUserKeys()
            ->where('server_id', $server->id)
            ->first();

        // If there was a result, we need to get the actual SSH key from it
        if ($sshKey) {
            $sshKey = $sshKey->sshKey;
        }

        // If there is no SSH key, get the default key
        if (! $sshKey) {
            $sshKey = $this->user->sshKeys()->where('is_default', 1)->first();
        }

        // If there is still no key, throw an error
        if (! $sshKey) {
            return 'noKey';
        }

        // Get the ssh client
        $ssh2 = new SSH2($server->address, $server->port);

        // Get the rsa service
        $rsa = new RSA();

        // Load the key
        $rsa->loadKey($sshKey->key);

        // Log into the server
        $status = $ssh2->login($server->username, $rsa);

        // Make sure log in was successful
        if (! $status) {
            if ($ssh2->isConnected()) {
                return 'badCredentials';
            }

            return 'cannotConnect';
        }

        // Return the SSH connection
        return $ssh2;
    }

    /**
     * Get authorized keys
     * @param Server $server
     * @return ModelCollection|string
     */
    public function getAuthorizedKeys(Server $server)
    {
        // Create a collection for the keys
        $collection = new ModelCollection();

        // Get the SSH Connection
        $conn = $this->getConnection($server);

        // If the connection is a string, it's an error, return it
        if (is_string($conn)) {
            return $conn;
        }

        // Connect to the server and get the keys
        $keys = explode("\n", $conn->exec('cat ~/.ssh/authorized_keys'));

        // Iterate through the keys, create a model, and add to the collection
        foreach ($keys as $key) {
            // Make sure the key is not the last empty line
            if (empty($key)) {
                continue;
            }

            // Create a new model and add it to the collection
            $collection->addModel(new ServerAuthorizedKey([
                'key' => $key
            ]));
        }

        // Return the collection
        return $collection;
    }

    /**
     * Add an authorized key
     * @param Server $server
     * @param string $key
     * @return bool|string
     */
    public function addAuthorizedKey(Server $server, string $key)
    {
        // Trim the key
        $key = trim($key);

        // Get the SSH Connection
        $conn = $this->getConnection($server);

        // If the connection is a string, it's an error, return it
        if (is_string($conn)) {
            return $conn;
        }

        // Check if the key exists
        $keyExists = $conn->exec(
            'grep "' . $key . '" $HOME/.ssh/authorized_keys;'
        );

        // If the key already exists, bail out
        if (! empty($keyExists)) {
            return true;
        }

        // Add the key
        $conn->exec('echo "' . $key . '" >> $HOME/.ssh/authorized_keys;');

        // We're done here
        return true;
    }

    /**
     * Delete authorized key
     * @param Server $server
     * @param string $key
     * @return bool|string
     */
    public function removeAuthorizedKey(Server $server, string $key)
    {
        // Get the SSH Connection
        $conn = $this->getConnection($server);

        // If the connection is a string, it's an error, return it
        if (is_string($conn)) {
            return $conn;
        }

        // Run the shell commands to delete the key
        $response = $conn($server)->exec(
            'if test -f $HOME/.ssh/authorized_keys; then ' .
                'if grep -v "' . $key . '" $HOME/.ssh/authorized_keys > $HOME/.ssh/tmp; then ' .
                    'cat $HOME/.ssh/tmp > $HOME/.ssh/authorized_keys && rm $HOME/.ssh/tmp; ' .
                'fi ' .
            'fi'
        );

        // Return the response boolean
        return ! $response;
    }
}
