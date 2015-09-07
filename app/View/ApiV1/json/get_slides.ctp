<?php
$result = array();
foreach ($slides as $slide) {
    $a['Slide']['id'] = $slide['Slide']['id'];
    $a['Slide']['name'] = $slide['Slide']['name'];
    $a['Slide']['description'] = $slide['Slide']['description'];
    $a['Slide']['created'] = $slide['Slide']['created'];
    $a['Slide']['downloadable'] = $slide['Slide']['downloadable'];
    $download_url = $this->Html->url(array("controller" => "slides", "action" => "download", $slide['Slide']["id"], "full_base" => true));
    if($slide['Slide']['downloadable']) {
        $a['Slide']['download_url'] = $download_url;
    } else {
        $a['Slide']['download_url'] = '';
    }
    $a['Slide']['thumbnail_url'] = $this->Common->thumbnail_url($slide['Slide']['key']);
    $a['Slide']['tags'] = $slide['Slide']['tags'];
    $a['Slide']['category_id'] = $slide['Category']['id'];
    $a['Slide']['category_name'] = $slide['Category']['name'];
    $a['Slide']['user_id'] = $slide['User']['id'];
    $a['Slide']['user_name'] = $slide['User']['display_name'];
    $result[] = $a;
}
$slides = $result;
echo json_encode(compact('slides'));
