<?php
function myTest() {
    static $x = 0;
    echo $x;
    $x++;
}
myTest(); // 출력 0
myTest(); // 출력 0
myTest(); // 출력 0
