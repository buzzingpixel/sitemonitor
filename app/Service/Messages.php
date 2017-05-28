<?php

namespace App\Service;

/**
 * Class Message
 */
class Messages
{
    /**
     * Add message
     * @param string $key
     * @param string $heading
     * @param bool|string|array $message
     * @param string $type info|success|warning|danger - default = info
     * @param bool $forward default = false
     */
    public static function addMessage(
        $key,
        $heading,
        $message = false,
        $type = 'info',
        $forward = false
    ) {
        $messages = array();

        if (\Session::has('messages')) {
            $messages = \Session::get('messages');
        }

        $messages[$key]['heading'] = $heading;
        $messages[$key]['message'] = $message;
        $messages[$key]['type'] = $type;

        if ($forward) {
            \Session::flash('messages', $messages);
            return;
        }

        \Session::now('messages', $messages);
    }
}
