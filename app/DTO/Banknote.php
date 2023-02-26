<?php

namespace App\DTO;

class Banknote
{
    private  int $banknote;

    public function __construct(int $banknote)
    {
        $this->banknote = $banknote;
    }

    public function get(): int
    {
        return $this->banknote;
    }

//    private function banknoteParsing(): array
//    {
//        $result = [];
//        $remainder = 0;
//
//        if ($this->banknote > BanknoteNominals::FIVE_THOUSAND) {
//            $remainder = $this->banknote % BanknoteNominals::FIVE_THOUSAND;
//            $result['five-thousand'] = ($this->banknote - $remainder) / BanknoteNominals::FIVE_THOUSAND;
//        }
//
//        if ($remainder >= BanknoteNominals::TWO_THOUSAND) {
//            $remainder = $remainder % BanknoteNominals::TWO_THOUSAND;
//            $result['five-thousand'] = ($this->banknote - $remainder) / BanknoteNominals::TWO_THOUSAND;
//        }
//
//        if ($remainder >= BanknoteNominals::THOUSAND) {
//            $remainder = $remainder % BanknoteNominals::THOUSAND;
//            $result['five-thousand'] = ($this->banknote - $remainder) / BanknoteNominals::THOUSAND;
//        }
//
//        if ($remainder >= BanknoteNominals::THOUSAND) {
//            $remainder = $remainder % BanknoteNominals::THOUSAND;
//            $result['five-thousand'] = ($this->banknote - $remainder) / BanknoteNominals::THOUSAND;
//        }
//
//        return $result;
//    }
}
