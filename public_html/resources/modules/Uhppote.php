<?php

namespace UhppotePHP\Modules;

class Uhppote
{
    static function Search()
    {

        $a = new \UhppotePHP\UhppoteAPI();
        $cmd = $a->getCmdHex('search');
        $ip = "255.255.255.255";
        $port = 60000;
        $sock = createSocket();
        socket_set_option($sock, 1, 6, TRUE);
        $input = hex2bin($cmd);

        if (!socket_sendto($sock, $input, strlen($input), 0, $ip, $port)) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);
            echo "There is error\n";
            exit;
        }

        $reply = getReturnPacket($sock);

        $procmsg = $a->procCmd(bin2hex($reply));


        var_dump($procmsg);



        function createSocket()
        {
            if (!($sock = socket_create(AF_INET, SOCK_DGRAM, 0))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);

                die("Couldn't create socket: [$errorcode] $errormsg \n");
            }
            return $sock;
        }


        function getReturnPacket($sock)
        {
            if (socket_recv($sock, $reply, 2045, MSG_WAITALL) === FALSE) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);

                die("Receive socket Error: [$errorcode] $errormsg \n");
            }
            return $reply;
        }
    }
}
