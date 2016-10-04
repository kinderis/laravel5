<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paysera extends Model
{
    public function getResulData($csvFile)
    {
        $cash_in = Paysera::get_cash_in ($csvFile);
        return $cash_in;
    }

    public function DataArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                $header = array('date', 'uid', 'person', 'operation', 'cash', 'currency');
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

    /* komisinio fiziniam asmeniui paskaiciavimas */
    public function get_user_cash ($data,$uid,$date,$select){
        $lastMonday = strtotime($date." last Monday ");
        $nextSunday = strtotime($date." next Sunday ");
        $ar_curse = array ('EUR' => '1','USD' => '1.1497', 'JPY'=> '129.53' );
        $limt_fre = '1000';

        $ar = array();
        foreach ($data as $dates) {
            if($dates['operation'] == 'cash_out' && $dates['uid'] == $uid && ($lastMonday <= strtotime($dates['date']) && $nextSunday >= strtotime($dates['date'])))
            {
                (array_key_exists($dates['currency'],$ar_curse))? $cash_eu = ($dates['cash']/$ar_curse[$dates['currency']]): $cash_eu = $dates['cash'];
                $ar[] = array(
                    'date' => $dates['date'],
                    'uid' => $dates['uid'],
                    'cash_eu' => $cash_eu,
                    'cash' => $dates['cash'],
                    'currency' => $dates['currency']
                );
            }
        }

        $cash = 0;
        $count_Ar = (count($ar)-1);
        $cash_f = array();
        for ($i=0;$i<=$count_Ar;$i++){
            $cash += $ar[$i]['cash_eu'];
            switch ($i) {
                case 0;
                    ($cash <= $limt_fre)? $com = '0' : $com = ((($ar[$i]['cash']-($limt_fre*($ar_curse[$ar[$i]['currency']])))*0.3)/100);
                    break;
                case 1;
                    if (($cash-$ar[$i]['cash_eu']) >= $limt_fre) {$com = (($ar[$i]['cash']*0.3)/100);}
                    else {$com = ((($ar[$i]['cash']-($limt_fre*($ar_curse[$ar[$i]['currency']])))*0.3)/100);}
                    break;
                case $i >= 2;
                    $com = (($ar[$i]['cash']*0.3)/100);
                    break;
            }
            $cash_f[$ar[$i]['date']."_".$ar[$i]['cash']."_".$select] = $com;
        }
        return $cash_f;
    }

    /* Komisinio paskaiciavimas */
    public function get_cash_in ($csvFile){
        $i =0;
        $com_array = array();
        $data = Paysera::DataArray($csvFile);
        foreach ($data as $dates) {
            $i++;
            switch ($dates['operation']) {
                case "cash_in":
                    $com = (($dates['cash']*0.03)/100);
                    ($com > 5) ? $com = '5.00' : $com = $com;
                    break;
                case "cash_out":
                    $com = (($dates['cash']*0.3)/100);
                    if ($dates['person'] == 'juridical'){($com < 0.5 ) ? $com = '0.50' : $com = number_format($com, 2, '.', '');}
                    elseif ($dates['person'] == 'natural') {
                        $com = Paysera::get_user_cash($data,$dates['uid'],$dates['date'],$i);
                        $com = $com[$dates['date']."_".$dates['cash']."_".$i];
                        $com = number_format(round( $com, 3, PHP_ROUND_HALF_UP), 2, '.', '');
                    }
                    break;
            }
            $com_array[] = $com;
        }
        return $com_array;
    }
}