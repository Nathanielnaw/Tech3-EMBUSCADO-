<?php

if (! function_exists('avatar_filename_is_safe')) {
    function avatar_filename_is_safe(?string $filename): bool
    {
        return $filename !== null
            && preg_match('/\A[a-f0-9]{32}\.(?:jpg|png)\z/', $filename) === 1;
    }
}

if (! function_exists('avatar_url')) {
    function avatar_url(?string $filename): string
    {
        if (avatar_filename_is_safe($filename)
            && is_file(FCPATH . 'uploads/avatars/' . $filename)) {
            return base_url('uploads/avatars/' . rawurlencode($filename));
        }

        return base_url('images/avatar-placeholder.svg');
    }
}
