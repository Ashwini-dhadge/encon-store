<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function load_jpgraph() {
    require_once(APPPATH . 'third_party/jpgraph/src/jpgraph.php');
    require_once(APPPATH . 'third_party/jpgraph/src/jpgraph_line.php');
    require_once(APPPATH . 'third_party/jpgraph/src/jpgraph_bar.php');

    // require_once ('jpgraph/jpgraph_bar.php');
}
