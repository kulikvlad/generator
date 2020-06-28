<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

/**
 * ContactForm is the model behind the contact form.
 */
class GeneratorChart extends Model
{

    public $date;
    public $numberMonths;
    public $amount;
    public $interestRate;
    public $chartId = 0;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [];
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setNumberMonths($numberMonths)
    {
        $this->numberMonths = $numberMonths;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
    }

    public function getTimestamp($date)
    {
        return strtotime($date);
    }

    public function getDateFromTimestamp($date)
    {
        return date('Y-m-d', $date);
    }

    public function getPrincipalDebtInMonth()
    {
        return $this->amount / $this->numberMonths;
    }

    public function getInterestDebtInYear()
    {
        return ($this->amount * $this->interestRate) / 100;
    }

    public function roundingNumber($number)
    {
        return floor($number*100)/100;
    }

    public function getLastChart()
    {
        return Charts::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }

    public function createChart()
    {
        $lastChart = $this->getLastChart();
        $lastChart = ++$lastChart->attributes['id'];
        $chart = new Charts();
        $chart->title = "Chart number $lastChart";
        $chart->save();
        return $lastChart;
    }

    public function createPayments()
    {
        $dateInTimestamp = $this->getTimestamp($this->date);
        $residuePrincipalDebt = $this->amount;
        $this->chartId = $this->createChart();
        $currentPrinciple = 0;

        for($i = 1; $i <= $this->numberMonths; $i++)
        {
            // date generation
            $dateInTimestamp += 2592000;
            $date = $this->getDateFromTimestamp($dateInTimestamp);

            // interest debt generation
            $interestDebt = $this->getInterestDebtInYear();
            $interestDebt = $interestDebt /  12;
            $interestDebt = $this->roundingNumber($interestDebt);

            // principle debt generation
            $principalDebt = $this->roundingNumber($this->getPrincipalDebtInMonth());

            // residue principal debt generation
            $residuePrincipalDebt -= $principalDebt;

            // current values for calculating the exact values of the last payment
            $currentPrinciple += $principalDebt;

            // last payment generation
            if($i == $this->numberMonths)
            {
                $principalDebt += $this->amount - $currentPrinciple;
                $residuePrincipalDebt = 0;
            }

            // total debt generation
            $totalDebt = $principalDebt + $interestDebt;

            // adding payments
            $payment = new Payments();
            $payment->number = $i;
            $payment->chart_id = $this->chartId;
            $payment->date = $date;
            $payment->total = $totalDebt;
            $payment->principle = $principalDebt;
            $payment->interest = $interestDebt;
            $payment->residuePrincipalDebt = $residuePrincipalDebt;
            $payment->save(false);

        }
        return $this->chartId;
    }
    public function Run()
    {
        return $this->createPayments();
    }
}
