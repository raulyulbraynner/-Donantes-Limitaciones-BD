<?php
if (is_dir("../img") && is_writable("../img") ) {
    echo "Bien";
} else {
    echo 'Upload directory is not writable, or does not exist.';
}