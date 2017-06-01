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
     * @return SSH2
     */
    public function getConnection(Server $server) : SSH2
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
            abort(
                500,
                'You have not selected a key for this server nor specified a default key'
            );
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
                abort(
                    500,
                    'Bad username or key'
                );
            }

            abort(
                500,
                'Unable to establish an SSH connection with the server'
            );
        }

        // Return the SSH connection
        return $ssh2;
    }

    /**
     * Get authorized keys
     * @param Server $server
     * @return ModelCollection
     */
    public function getAuthorizedKeys(Server $server) : ModelCollection
    {
        // Create a collection for the keys
        $collection = new ModelCollection();

        // Connect to the server and get the keys
        $keys = explode(
            "\n",
            $this->getConnection($server)->exec('cat ~/.ssh/authorized_keys')
        );

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
}
