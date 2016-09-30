<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paysera extends Model
{
    public function getResulData()
    {
        function csv_to_array($filename='', $delimiter=',')
        {
            if(!file_exists($filename) || !is_readable($filename))
                return FALSE;

            $header = NULL;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
                {
                    $header = array ('date','uid','person','operation','cash','currency');
                    $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            return $data;
        }
        $csvFile = public_path().'/csv/operation_x.csv';
        $data = csv_to_array($csvFile);

        function get_user_cash ($data,$uid,$date){
            $lastMonday = strtotime($date." last Monday ");
            $nextSunday = strtotime($date." next Sunday ");

            foreach ($data as $dates) {
                if($dates['operation'] == 'cash_out' && $dates['uid'] == $uid && ($lastMonday <= strtotime($dates['date']) && $nextSunday >= strtotime($dates['date'])))
                {
                   $ar[] = $dates;
                }
            }
            return $ar;
        }

         $data = get_user_cash($data, '1','2016-02-15');

        $data = $data;
        /* Komisinio paskaicivimas */
        function get_cash_in ($data){

            foreach ($data as $dates) {
                switch ($dates['operation']) {
                    case "cash_in":
                        $com = (($dates['cash']*0.03)/100);
                        ($com > 5) ? $com = '5.00' : $com = $com;
                        break;
                    case "cash_out":
                        $com = (($dates['cash']*0.3)/100);
                        if ($dates['person'] == 'juridical'){($com < 0.5 ) ? $com = '0.50' : $com = number_format($com, 2, '.', '');}
                        elseif ($dates['person'] == 'natural') { ($dates['cash'] > '1000' )? $com = (($dates['cash']*0.3)/100): $com = "0.00";}
                        break;
                }
                $com_array[] = $com;
            }
            return $com_array;
        }
        $cash_in = get_cash_in ($data);
       # $cash_in[] = array_search('cash_in', array_column($data, 'operation'));
        #return $cash_in;
        return $data;
    }

    public function scopeResult ($id) {

    }
}
