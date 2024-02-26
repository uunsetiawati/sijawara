<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;
use App\KrmPesan\ClientV3;

class SendNotif
{
    static function send($no, $message)
    {

        $dat = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $date = $dat->format('H');
        if ($date < 12)
            $greet = "Pagi";
        else if ($date < 17)
            $greet = "Siang";
        else if ($date < 20)
            $greet = "Sore";
        else
            $greet = "Malam";

        $wa = new ClientV3([
            'deviceId' => 'ap-southeast-1_8ae3ccf6-6896-426f-a8c3-b1bc19e5272b',
            'refreshToken' => 'eyJjdHkiOiJKV1QiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiUlNBLU9BRVAifQ.sfcEfbdxdKudxMqWOD3lc_4xGrgdRe6XNKKv9YqYx52IT0BzmjMjSqlroVNS6J1lavTV4p5H9fvbjRLTlbdhxvi9BvEgLzjn3dyTbChZpaNSXsJj-D3W4C1uBaaYazIZJ7ATrmzI_mOzdSZydTs1DU5hkbOZoc5j75ePdZ-8VqVPjujIHfe9iSqttHEpXawKoYz5rk35f2JTIOwmiAV59g811lGpL1x_1aDPS2_LhQMXP0w2adSje_g3AG7C2Co8RnBvzDI2oHKX5Mz3GN56aRJ9IBFd4bvtKZtCYPTEmAohUvZK6fVotQO5gFR2aZ7bYWNVLxEFbAu7seIx5dryvg.y9PCuNVdaG_0pOAz.UzFNKLKLt8K1G6xLabXWMyHRSzfyVpQLKn3MyLHrJvhHb-pOhOuVGwq7cqugrsi6rIgViYqF1GmlamAUPb2EcIyAozM7aFkoMTVbWAUKo3wE7Alby0qaQZq-TMUZJs7ZwYJL-CcUDPOCMjTuspPyzNV6Ll6Rzixp53gl2vPe7mILJZ3WSay45rSpdUYKkQHsxMGL61xLCv-y22IWDBDo18xQnfQ0I6cNZ22r9zaKkeOYF0kKbL0u8oZOyZk4oq69n4wBO1JHRjVfxI7WReq39y43Ezsh7wwn8wEvzKQSlwWQS0VjF2lGUdzG2J5l_tba21GTsER4oXY5t2RAnpU4tvchaRh_PY3digrfZMufKdWuDmVJTgTmWDblJE2cDRacO1elgaFsa9_FRSCPKugrS9HUDbWZ1A1Kb4JHsFiIhrzpUPshQPcD1xWp4DlTyxxuGCBPZADCBVT4dkuGS8qJgp6C7BC3IUs2WoFmT0ez98coCa0PVtuHw4uDePbRzTl6AtujnT0TAdjslFLGtg46LHqsJcDU5TiBhkFjoes2B6Ar5GvmaJgch1LHxvahNNl93lppfdHRevmeTDnlJlZjVv0LzQYSwIgNUmBSFzMCBdw1LnLI1BTYLAltx39f_M8HlqoNKVHE3ddRxKeJ2MkzzW0jaNsFM9hLCBtJ5K5Pt_jVOlF31ISoqsspRVnQC89Bjj0UoUcnMjSvADkZ2Akn3MBsFPp7YSD6AdRQCKsm0LOoKnecZbA_45oWUKjahvl7mMIWBrVJAf6bCANHNteBt5OclaE6I4QyYkroE_o3VcSfXN8UEQ0Q9eg3z5BtUX158ieYvi_6Tb0dAYeZLb-Z7huM9SEmriA_aP-CzyPIq2e1R-6riUJXSadSq5q3-tCoeVxM0xVso8sijthcubJtpjRaZhzZdMYQPYOgwmbJD4LRN7leU_pXKDAjiwEidtedu7OdKxoQM6rGZSLgOThOqPRjIAK9w-1HQU85-tReVgtOSYUH47jgKuoV21cbg-aN37kYo-6JvIWWmB6oUbQCkn2UNMn2TOcwXC33NDHNDvez0bU4FmzWz8T6eu-7r0OOP8i2lEuYIyrxY_smV5cjhEZO56HPB_oZRKtwTsEW8TlujLiYAtHvkq0ig5UcgwyPUAgMr0UfQVaEQqeNtMflwEDE_GGGh41_DGe1TDRykTwoJeStq5jH9X7eWmfa4dFC9MIQPar7hTNbZnSPoGj4Swz1iPjFpeoagpU7M68DskFziCf4HQObgg5ZPw2TPxkyxmU3X1qkHpv1ceCFlX7nU2L96UC99vybwffuGxUkK3llT3TTQa3TaejYeSt0VH7LLQSjv4ivtt0AFEw3Pw3ujxl6knkWNCJkoy2Jq82vIizVWIjmJsxgzswqNpyXyHpRNxldsKTGY2oLuGvHHHpCfaDQ2VoeWUiv3Fh_SMVr04ycsRpI7Q9WkcLjxwF7ENrI-iT1PmWT.35eyKiOtv-8JLwDxQtRjrA',
            'idToken' => 'eyJraWQiOiJnUFdURUFqekZLTmFnTGhSa28rbGszeEhRMCtEWm42Z29XcDR1ZEhvV0RZPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiIxMWEzZjNmNS1lZjU0LTQ2NzktODBiNS0yM2YzZTk3MGRhNjciLCJjb2duaXRvOmdyb3VwcyI6WyJERVYjNjIzMTg2NzUwODIiLCJ1c2VyIl0sImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJpc3MiOiJodHRwczpcL1wvY29nbml0by1pZHAuYXAtc291dGhlYXN0LTEuYW1hem9uYXdzLmNvbVwvYXAtc291dGhlYXN0LTFfRWtDNHpiVFV1IiwiY29nbml0bzp1c2VybmFtZSI6IjExYTNmM2Y1LWVmNTQtNDY3OS04MGI1LTIzZjNlOTcwZGE2NyIsIm9yaWdpbl9qdGkiOiJmNzQ3MmYxNy1mY2FiLTQ2MzQtYWQ3MC1mOGU2NjA5ZjhjYjYiLCJhdWQiOiIyMm12ZzJzYXNmOWg2bG01YXVpOGIwcjdqaiIsImV2ZW50X2lkIjoiOGE4OTA2NjctMzEzNC00ZDNlLTgzMDItNzNiZjEyOTdhOTk4IiwidG9rZW5fdXNlIjoiaWQiLCJhdXRoX3RpbWUiOjE2Nzc3NzQwMzMsIm5hbWUiOiJEaW5hcyBLb3BlcmFzaSBEYW4gVUtNIFByb3YgSmF0aW0iLCJleHAiOjE2Nzc4NjA0MzMsImlhdCI6MTY3Nzc3NDAzMywianRpIjoiYTcyYTA0MGYtY2FmNC00NGY2LTg0NWYtYmE4ZjQzYTdiZjBjIiwiZW1haWwiOiJkaXNrb3B1a20ucHJvdmphdGltQGdtYWlsLmNvbSJ9.tz68T_EipllUEZrckAujA9cHSN3KXWuo_yyj6Cj7NQUFS4wfR2bZCMsaIqRTykZZpBYXJE0WBGLdvx8vdv0BccfsHGU4UOcsq7M_dmLTwBn_SfzJHh63Qv6wTWxamsGwW3KEzDz5mfdmI3fXKniLZzWUf3LhESZD_CgYbfmqSBiOVf-g2YCWPQ6x8ocPkfB1b7qLSznN1nTWW1KjZ7NiIBrT3Rlqwxb5EPdWKSjHK3Aj4EBSwbiczre2bCznHg14LjsBjkeWpFhA83RTXr4vyFVmWte7PRjiNScmtbgcTRxGw8fSAegVuH2Q5fT5Q1FvCSp1ypFYpRccOC74gCEZbw',
        ]);

        $wa->refreshToken();

        $body = [
            $greet,
            $message
        ];
        
        return $wa->sendMessageTemplateText($no, 'sijawara', 'id', $body);



        // return $response;
    }
}
