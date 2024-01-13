<?php
//   <i class=" bx bx-list-ul" style=""></i>
if (isset($headerType) && $headerType == 'List') {
    $html = '<div class="cards">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div href="#" style="font-size: 18px;font-weight:700">
            <i class=" bx bx-list-ul"></i>';

    if (isset($leftSideName)) {
        $html .= $leftSideName;
    }
    $html .= '</div>
        <div>';

    if (isset($routePath)) {
        $route = $basePath . '/' . $routePath;
        $html .= '<a href="' . $route . '" class="btn btn-sm btn-gradient-primary">';
    }

    if (isset($rightSideName)) {
        $html .= '<i class=" bx bx-message-alt-add" ></i>' . $rightSideName;
    }

    $html .= '</a>
        </div>
    </div>
</div>';
}
else {
    $html = '<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div href="#" style="font-size: 18px;font-weight:700">
            <i class=" bx bx-edit"></i>';

    if (isset($leftSideName)) {
        $html .= $leftSideName;
    }
    $html .= '</div>
        <div>';

    if (isset($routePath)) {
        $route = $basePath . '/' . $routePath;
        $html .= '<a href="' . $route . '" class="btn btn-sm btn-gradient-primary">';
    }

    if (isset($rightSideName)) {
        $html .= '<i class="bx bx-list-ul" ></i>' . $rightSideName;
    }

    $html .= '</a>
        </div>
    </div>
</div>';
}
echo $html;

?>