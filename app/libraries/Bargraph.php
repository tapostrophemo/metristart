<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/sparkline-php-0.2/lib/Sparkline_Bar.php');

class Bargraph
{
  var $graph;

  function Bargraph() {
    $this->graph = new Sparkline_Bar();
    $this->graph->SetDebugLevel(DEBUG_NONE);
    $this->graph->SetColorHtml('black', '#626264');
    $this->graph->SetColorHtml('tan', '#D9D4AE');
  }

  function setData($data = array(), $posColor = 'black', $negColor = 'tan') {
    $i = 0;
    foreach ($data as $val) {
      $this->graph->SetData($i++, $val, $val >= 0 ? $posColor : $negColor);
    }
  }

  function render($height = 32, $barWidth = 3, $barSpacing = 1) {
    $this->graph->SetBarWidth($barWidth);
    $this->graph->SetBarSpacing($barSpacing);
    $this->graph->Render($height);

    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Expires: 0');
    header('Pragma: no-cache');
    $this->graph->Output();
  }
}

