<?php
// config/escapeString.php

function escapeString($koneksi, $data)
{
    return mysqli_real_escape_string($koneksi, htmlspecialchars(trim($data)));
}
