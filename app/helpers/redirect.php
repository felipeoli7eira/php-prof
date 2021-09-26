<?php

function redirect(string $url_path): void {

    http_response_code(301);
    header("Location: {$url_path}");
    exit();
}
