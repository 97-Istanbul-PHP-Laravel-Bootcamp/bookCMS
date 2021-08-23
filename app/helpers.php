<?php

function statusCSS($status)
{
    $arr_ = [
        'a' => 'success',
        'p' => 'danger',
        't' => 'warning'
    ];

    return $arr_[$status];
}


function getR($obj_, $obj, $prop)
{

    if ($obj === TRUE) {
        foreach ($obj_ as $key => $val_) {
            $arr_[$key] = $val_[$prop];
        }
        return $arr_;
    }

    if ($prop === TRUE && $obj_[$obj]) {
        return $obj_[$obj];
    }

    return isset($obj_[$obj][$prop]) ? $obj_[$obj][$prop] :  $obj;
}


function decodeX($value)
{
    if (is_null($value)) {
        return [];
    }
    return explode("|", substr($value, 1, -1));
}

function encodeX($value)
{
    $value = (array) $value;

    if (count($value) == 0 || !$value) {
        $string =  null;
    } else {
        $string = "|" . implode("|", $value) . "|";
    }

    return $string;
}


function getCid_()
{
    return [
        1 => 'TL'
    ];
}


// Date input exchange
// DB : Y-m-d
// Client : d/m/Y minute

function diex($date, $datetime = false)
{
    if ($datetime) {
        $format1 = 'Y-m-d H:i:s';
        $format2 = 'd/m/Y H:i';
    } else {
        $format1 = 'Y-m-d';
        $format2 = 'd/m/Y';
    }

    if (isValidDate($date, $format1)) {
        $d = DateTime::createFromFormat($format1, $date);
        return $d->format($format2);
    }

    if (isValidDate($date, $format2)) {
        $d = DateTime::createFromFormat($format2, $date);
        return $d->format($format1);
    }

    return $date;
}


function isValidDate($date, $format = "Y-m-d H:i:s")
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


function getDatesFromRange($start, $end, $format = 'Y-m-d')
{
    $array = array();

    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach ($period as $date) {
        $array[] = $date->format($format);
    }

    return $array;
}


function generateCodeByID($id)
{
    $id = str_pad($id, 6, '0', STR_PAD_LEFT);
    $r_id = (string)rand(10, 99);
    return (date('y') - 20) . date('m') . $r_id{0} . $id{0} . $id{1} . $id{2} . $r_id{1} . $id{3} . $id{4} . $id{5};
}
