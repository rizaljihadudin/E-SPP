<?php

function formatRupiah($nominal, $prefix = null)
{
    $prefix = $prefix ? $prefix : 'Rp. ';
    return $prefix . number_format($nominal, 2, ',', '.');
}

function terbilang($nominal)
{
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($nominal < 12)
        return " " . $angka[$nominal];
    elseif ($nominal < 20)
        return terbilang($nominal - 10) . " belas";
    elseif ($nominal < 100)
        return terbilang($nominal / 10) . " puluh" . terbilang($nominal % 10);
    elseif ($nominal < 200)
        return "seratus" . terbilang($nominal - 100);
    elseif ($nominal < 1000)
        return terbilang($nominal / 100) . " ratus" . terbilang($nominal % 100);
    elseif ($nominal < 2000)
        return "seribu" . terbilang($nominal - 1000);
    elseif ($nominal < 1000000)
        return terbilang($nominal / 1000) . " ribu" . terbilang($nominal % 1000);
    elseif ($nominal < 1000000000)
        return terbilang($nominal / 1000000) . " juta" . terbilang($nominal % 1000000);
}
