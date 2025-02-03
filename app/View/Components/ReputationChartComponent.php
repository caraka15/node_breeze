<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReputationChartComponent extends Component
{
    public $chartId;
    public $chartTitle;
    public $chartDescription;

    public function __construct($chartId = 'reputationChart', $chartTitle = 'Reputation History (24h)', $chartDescription = 'Reputation changes over time')
    {
        $this->chartId = $chartId;
        $this->chartTitle = $chartTitle;
        $this->chartDescription = $chartDescription;
    }

    public function render()
    {
        return view('components.reputation-chart');
    }
}
